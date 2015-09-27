{{-- Jquery CDN --}}
{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js')}}
{{-- Check to see if Jquery loaded from CDN, if not, locally load it --}}
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
{{ HTML::script('js/vendor/plugins.js')}}
{{-- AngularJS   --}}
{{-- HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.0.1/angular.min.js') --}}
{{-- Twitter Bootstrap 3  --}}
{{ HTML::script('js/vendor/bootstrap.min.js')}}
{{-- Site specific JavaScript  --}}
{{ HTML::script('js/main.js')}}