<div align="center">

    {{ form() }}

    <div align="center">
        <h2>Reset Password</h2>
    </div>

    <table class="signup">
        <tr>
            <td colspan="2">
                {{ form.render('token') }}

                {% for message in form.getMessagesFor('token') %}
                    <div class="alert alert-danger alert-dismissable">
                        {{ message }}
                    </div>
                {% endfor %}
            </td>
        </tr>
        <tr>
            <td align="right">{{ form.label('password') }}</td>
            <td>
                {{ form.render('password') }}

                {% for message in form.getMessagesFor('password') %}
                    <div class="alert alert-danger alert-dismissable">
                        {{ message }}
                    </div>
                {% endfor %}
            </td>
        </tr>
        <tr>
            <td align="right">{{ form.label('confirmPassword') }}</td>
            <td>
                {{ form.render('confirmPassword') }}

                {% for message in form.getMessagesFor('confirmPassword') %}
                    <div class="alert alert-danger alert-dismissable">
                        {{ message }}
                    </div>
                {% endfor %}
            </td>
        </tr>
        <tr>
            <td align="right"></td>
            <td>{{ form.render('Reset') }}</td>
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