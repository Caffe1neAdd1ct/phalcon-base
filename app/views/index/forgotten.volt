<div align="center">

    {{ form() }}
    
    <br>
    <a href="/index">Homepage</a>
    <br>


    <div align="center">
        <h2>Forgotten Password</h2>
    </div>

    <table class="forgotten">
        <tr>
            <td>
                <div class="form-group">
                    {{ form.label('username') }}
                    {{ form.render('username') }}

                    {% for message in form.getMessagesFor('username') %}
                        <div class="alert alert-danger alert-dismissable">
                            {{ message }}
                        </div>
                    {% endfor %}
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    {{ form.label('email') }}
                    {{ form.render('email') }}

                    {% for message in form.getMessagesFor('email') %}
                        <div class="alert alert-danger alert-dismissable">
                            {{ message }}
                        </div>
                    {% endfor %}
                </div>
            </td>
        </tr>
        <tr>
            <td><div class="form-group">{{ form.render('Request') }}</div></td>
        </tr>
    </table>

    {{ form.render('csrf', ['value': security.getToken()]) }}

    {% for message in form.getMessagesFor('csrf') %}
        <div class="alert alert-danger alert-dismissable">
            {{ message }}
        </div>
    {% endfor %}

    <hr>

    {{ endForm() }}

</div>