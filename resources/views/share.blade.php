{{-- Necessary to inject dump scripts and styles --}}
{{ dump(null) }}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <style>
            pre.sf-dump {
                display: none !important;
            }
        </style>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="robots" content="noindex, nofollow">

        <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Arr::get($share->data, 'message'), 25) }} | {{ config()->get('app.name') }}</title>

        <meta name="msapplication-TileColor" content="#FF2D20">
        <meta name="theme-color" content="#FF2D20">

        <meta property="og:site_name" content="{{ config()->get('app.name') }}">
        <meta property="og:locale" content="en_US">

        <meta property="og:name" content="Shared error: {{ \Illuminate\Support\Arr::get($share->data, 'exception_class') }}">
        <meta property="og:description" content="{{ \Illuminate\Support\Arr::get($share->data, 'message') }} - The error occurred at {{ \Illuminate\Support\Arr::get($share->data, 'location') }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
        <link href="{{ mix('dist/laracatcher.js', 'dist') }}" rel="preload" as="script">

        <style>
            .delete {
                width: 100%;
                background-color: rgb(255, 45, 32);
                color: white;
                padding: 0.5em;
                position: fixed;
                z-index: 99;
            }

            .delete:hover {
                background-color: rgb(240, 35, 12);
            }
        </style>
    </head>
    <body>
        @if (request()->get('token') === $share->token)
            <form action="{{ route('share.delete', $share->id) }}" method="POST">
                @method('DELETE')
                <input type="hidden" name="token" value="{{ request()->get('token') }}">
                <button type="submit" class="delete">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        @endif

        <div id="app"></div>

        <script src="{{ mix('dist/laracatcher.js', 'dist') }}"></script>

        <script>
            window.data = {
                error: @json($share->data),
                solutions: @json(\Illuminate\Support\Arr::get($share->data, 'solutions', [])),
                config: {
                    directorySeparator: "/",
                    navigator: false,
                },
                defaultTab: 'StackTab'
            };

            window.Laracatch = window.laracatcher(window.data);

            Laracatch.start('#app');
        </script>
    </body>
</html>
