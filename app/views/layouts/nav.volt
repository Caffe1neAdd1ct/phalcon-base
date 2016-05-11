{% extends "layouts/base.volt" %}

{% block nav %}
    {{ super() }}

    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            
            <div class="navbar-static navbar-left">
                <a class="navbar-brand" href="#">
                    <span class="visible-lg-inline">My Application</span>
                </a>
            </div>

            <ul class="nav navbar-nav nav-tabs nav-tabs-justified navbar-right">
                <li><a href="/overview"><i class="glyphicon glyphicon-link"></i> <span class="visible-md-inline visible-lg-inline">Overview</span></a></li>
                <li><a href="/index/logout"><i class="glyphicon glyphicon-log-out"></i> <span class="visible-lg-inline">Logout</span></a></li>
            </ul>

        </div><!-- /.container-fluid -->
    </nav>
{% endblock %}