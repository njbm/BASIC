<template>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Item</th>  <th scope="col">Image</th>  <th scope="col">Price</th> <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(item,index) in items" :key="index">
      <td>{{ item.title }}</td>  <td><img class="rounded-circle" :src="item.image" height="30" width="30"></td>  
      <td>{{ item.price}} $</td> <td><button @click="removeItem(index)" class="btn btn-sm btn-danger">Delete</button></td>
    </tr>
  </tbody> 
     <tfoot>
      <td></td><td class="t">Total Price : </td> <td>&nbsp; {{total}} $</td>
    </tfoot>
</table>
</template>

<script >

export default{
   props:['items'],
   computed:{
            total(){
               var total=0;
               this.items.forEach(item => {
                  total += parseFloat(item.price)
               });
               return total+ '';
            }
   },
   methods:{
      removeItem(index){
         this.$emit('itemRemoved', index)
      }
   }

}


</script>

<style  scoped>
.t{ text-align: right; }
</style>