<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Spartan Commerce' }}</title>

        <!-- Include the Vite-built CSS and JS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="bg-slate-200 dark:bg-slate-700">
        @livewire('partials.navbar')
        <main>
            {{ $slot }}
        </main>
        @livewire('partials.footer')
        @livewireScripts
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
        <x-livewire-alert::scripts />
        <script>
            var botmanWidget = {
                aboutText: 'Start the conversation with Hi',
                introMessage: "Hi! My name is Spartan Botman and I am here to assist you. Just type hi to start the conversation with me."
            };
          </script>
          <script src="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js"></script>
          <script>
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof BotManWidget !== 'undefined') {
                    BotManWidget.init();
                }
            });
        
            // Reload bot widget after any significant Livewire update
            document.addEventListener('livewire:update', function () {
                if (typeof BotManWidget !== 'undefined') {
                    BotManWidget.init();
                }
            });
        </script>
    </body>
</html>