<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UpdateTableColumns extends Command
{
    protected $signature = 'table:update
                            {table : The name of the table to modify}
                            {--add= : Columns to add in the format columnName:type, e.g., "new_column:string"}
                            {--update= : Columns to update in the format columnName:type, e.g., "existing_column:string"}
                            {--delete= : Columns to delete, comma-separated, e.g., "old_column1,old_column2"}
                            {--set= : Set values for the columns, in format columnName:value, e.g., "new_column:defaultValue"}
                            {--setextra= : Set unique values for the columns, in format columnName:value, e.g., "new_column:defaultValue"}';

    protected $description = "Update table columns: add, update, or delete columns and set values if provided";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $table = $this->argument('table');

        if (!Schema::hasTable($table)) {
            $this->error("Table '{$table}' does not exist.");
            return;
        }

        $addColumns = $this->option('add');
        $updateColumns = $this->option('update');
        $deleteColumns = $this->option('delete');
        $setValues = $this->option('set');
        $setExtraValues = $this->option('setextra');

        // Add new columns only if they don't exist
        if ($addColumns) {
            $tableName = $table;
            $columnsToAdd = explode(',', $addColumns);

            foreach ($columnsToAdd as $column) {
                [$name, $type, $after] = array_pad(explode(':', $column), 3, null); // Allow for the optional 'after' parameter

                if (!Schema::hasColumn($tableName, $name)) {
                    Schema::table($tableName, function (Blueprint $table) use ($name, $type, $after) {
                        $columnDefinition = $table->{$type}($name)->nullable();
                        if ($after) {
                            $columnDefinition->after($after);
                        }
                        $this->info("Added column '{$name}' with type '{$type}'" . ($after ? " after '{$after}'." : "."));
                    });
                } else {
                    $this->info("Column '{$name}' already exists, skipping add.");
                }
            }
        }

        // Update columns (if they exist)
        if ($updateColumns) {
            $tableName = $table;
            $columnsToUpdate = explode(',', $updateColumns);

            foreach ($columnsToUpdate as $column) {
                [$oldName, $newNameType] = explode(':', $column);
                [$newName, $type] = explode('=', $newNameType);

                if (Schema::hasColumn($tableName, $oldName)) {
                    Schema::table($tableName, function (Blueprint $table) use ($oldName, $newName, $type) {
                        if ($oldName !== $newName) {
                            $table->renameColumn($oldName, $newName);
                        }

                        $columnInstance = $table->{$type}($newName);

                        $columnInstance->nullable()->default(null)->comment('')->change();
                    });

                    $this->info("Renamed column '{$oldName}' to '{$newName}' and updated type to '{$type}' in table '{$tableName}'.");
                } else {
                    $this->warn("Column '{$oldName}' does not exist in table '{$tableName}', skipping update.");
                }
            }
        }

        // Delete columns only if they exist
        if ($deleteColumns) {
            Schema::table($table, function (Blueprint $table) use ($deleteColumns) {
                $columnsToDelete = explode(',', $deleteColumns);
                foreach ($columnsToDelete as $column) {
                    if (Schema::hasColumn($table->getTable(), $column)) {
                        $table->dropColumn($column);
                        $this->info("Deleted column '{$column}'.");
                    } else {
                        $this->info("Column '{$column}' does not exist, skipping delete.");
                    }
                }
            });
        }

        // Set column values if provided and only if they are different
        if ($setValues) {
            $columnsToSet = explode(',', $setValues);
            foreach ($columnsToSet as $column) {
                [$name, $value] = explode(':', $column);
                if (Schema::hasColumn($table, $name)) {
                    $existingValue = DB::table($table)->value($name);
                    if ($existingValue != $value) {
                        DB::table($table)->update([$name => $value]);
                        $this->info("Set value '{$value}' for column '{$name}'.");
                    } else {
                        $this->info("Value '{$value}' for column '{$name}' is already set, skipping.");
                    }
                } else {
                    $this->error("Column '{$name}' does not exist.");
                }
            }
        }

        if ($setExtraValues) {
            $columnsToSet = explode(',', $setExtraValues);
            foreach ($columnsToSet as $column) {
                [$name, $value] = explode(':', $column);

                if (Schema::hasColumn($table, $name)) {
                    DB::table($table)->get()->each(function ($row) use ($table, $name, $value) {
                        $uniqueValue = ($value === 'uuid') ? (string) Str::uuid() : $value;
                        DB::table($table)
                            ->where('id', $row->id)
                            ->update([$name => $uniqueValue]);

                        $this->info("Set unique value '{$uniqueValue}' for column '{$name}' in row with ID '{$row->id}'.");
                    });
                } else {
                    $this->error("Column '{$name}' does not exist in table '{$table}'.");
                }
            }
        }

        $this->info('Table modification completed successfully.');
    }
}


/*
php artisan table:update users --add="banner:string,banner_image:string,social_links:json"
php artisan table:update your_table --add="description:text:name,price:integer:amount"
php artisan table:update users --update="badges:badges=text"
php artisan table:update collection_items --update="comment:comments=text,price=integer"
php artisan table:update your_table --delete="old_column1,old_column2"
php artisan table:update your_table --set="new_column1:defaultValue,new_column2:123"

php artisan table:update order_items --setextra="uuid:uuid"

php artisan table:update your_table --add="new_column:string" --delete="old_column" --set="new_column:default"

//add column then set value
php artisan table:update manage_menus --add="theme:string"
php artisan table:update manage_menus --set="theme:light"
*/



