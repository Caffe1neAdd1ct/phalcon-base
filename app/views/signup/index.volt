<div align="center">

    {{ form() }}

    <br>
    <a href="/index">Homepage</a>
    <br>

    <div align="center">
        <h2>Sign Up</h2>
    </div>
    

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
            <td>
                <div class="form-group">
                    {{ form.label('confirmPassword') }}
                    {{ form.render('confirmPassword') }}

                    {% for message in form.getMessagesFor('confirmPassword') %}
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
                    {{ form.render('terms') }} {{ form.label('terms') }}

                    {% for message in form.getMessagesFor('terms') %}
                        <div class="alert alert-danger alert-dismissable">
                            {{ message }}
                        </div>
                    {% endfor %}
                </div>
            </td>
        </tr>
        <tr>
            <td><div class="form-group">{{ form.render('Sign Up') }}</div></td>
        </tr>
    </table>

    {{ form.render('csrf', ['value': security.getToken()]) }}

    {% for message in form.getMessagesFor('csrf') %}
        <div class="alert alert-danger alert-dismissable">
            {{ message }}
        </div>
    {% endfor %}

    <hr>

    </form>

</div>