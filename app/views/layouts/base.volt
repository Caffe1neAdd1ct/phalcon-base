<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        {{ get_title() }}
        {{ stylesheet_link('css/bootstrap/bootstrap.min.css') }}
        {{ stylesheet_link('css/bootstrap/bootstrap-theme.min.css') }}
        {{ stylesheet_link('css/font-awesome/font-awesome.min.css') }}
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="nForced Website Hosting Limited">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {% block nav %}
                    {% endblock %}
                </div>
            </div>
                
            <div class="row">
                <div class="col-md-12">
                    <div id="messages">{{ flash.output() }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                {% block content %}
                {% endblock %}
                </div>
            </div>
        </div>

        {{ javascript_include('js/jquery/jquery.min.js') }}
        {{ javascript_include('js/bootstrap/bootstrap.min.js') }}
    </body>
</html>