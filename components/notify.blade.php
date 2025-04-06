


@if (session()->has('success'))
    <script>
        Notiflix.Notify.success("@lang(session('success'))");
    </script>
@endif

@if (session()->has('error'))
    <script>
        Notiflix.Notify.failure("@lang(session('error'))");
    </script>
@endif

@if (session()->has('warning'))
    <script>
        Notiflix.Notify.warning("@lang(session('warning'))");
    </script>
@endif

@if (session()->has('info'))
    <script>
        Notiflix.Notify.info("@lang(session('info'))");
    </script>
@endif

@stack('notify')

@if ($errors->any())
<script>
    "use strict";
    @foreach ($errors->unique() as $error)
    Notiflix.Notify.failure("{{ trans($error) }}");
    @endforeach
</script>
@endif
