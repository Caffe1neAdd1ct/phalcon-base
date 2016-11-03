{% extends "layouts/base.volt" %}

{% block nav %}
    {{ super() }}

    <nav class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container-fluid">
            
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Phalcon Base</a>
            </div>

            <ul class="nav navbar-nav nav-tabs nav-tabs-justified navbar-right">
                {% if hasAuth %}
                <li><a href="/overview"><i class="glyphicon glyphicon-link"></i> <span class="visible-md-inline visible-lg-inline">Overview</span></a></li>
                {% endif %}
                <li><a href="/index/logout"><i class="glyphicon glyphicon-log-out"></i> <span class="visible-lg-inline">Logout</span></a></li>
            </ul>

        </div><!-- /.container-fluid -->
    </nav>
{% endblock %}