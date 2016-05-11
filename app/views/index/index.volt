<div align="center">

    SignUp <a href="/signup">Here</a>

    <br><br>

    <div align="center">
        <h2>Login</h2>
    </div>
    
    {{ form() }}

    <table class="signup">
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
                    {{ form.label('password') }}
                    {{ form.render('password') }}

                    {% for message in form.getMessagesFor('password') %}
                        <div class="alert alert-danger alert-dismissable">
                            {{ message }}
                        </div>
                    {% endfor %}
                </div>
            </td>
        </tr>
        <tr>
            <td><div class="form-group">{{ form.render('Login') }}</div></td>
        </tr>
    </table>

    {{ form.render('csrf', ['value': security.getToken()]) }}

    {% for message in form.getMessagesFor('csrf') %}
        <div class="alert alert-danger alert-dismissable">
            {{ message }}
        </div>
    {% endfor %}
    
    {{ endForm() }}
    
    <br><br>
    
    <a href="/index/forgotten">Forgotten Password</a>
    
    <hr>

    

</div>