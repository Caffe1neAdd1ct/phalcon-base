
{{ content() }}

<div align="right">
    {{ link_to("users/new", "Create users") }}
</div>

{{ form("users/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search users</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="id">Id</label>
        </td>
        <td align="left">
            {{ text_field("id", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="username">Username</label>
        </td>
        <td align="left">
            {{ text_field("username", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="password">Password</label>
        </td>
        <td align="left">
            {{ text_field("password", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="email">Email</label>
        </td>
        <td align="left">
            {{ text_field("email", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="token">Token</label>
        </td>
        <td align="left">
            {{ text_field("token", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="valid">Valid</label>
        </td>
        <td align="left">
            {{ text_field("valid", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="created">Created</label>
        </td>
        <td align="left">
            {{ text_field("created", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="deleted">Deleted</label>
        </td>
        <td align="left">
            {{ text_field("deleted", "size" : 30) }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
