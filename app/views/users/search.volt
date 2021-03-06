
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("users/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("users/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Password</th>
            <th>Email</th>
            <th>Token</th>
            <th>Valid</th>
            <th>Created</th>
            <th>Deleted</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for user in page.items %}
        <tr>
            <td>{{ user.getId() }}</td>
            <td>{{ user.getUsername() }}</td>
            <td>{{ user.getPassword() }}</td>
            <td>{{ user.getEmail() }}</td>
            <td>{{ user.getToken() }}</td>
            <td>{{ user.getValid() }}</td>
            <td>{{ user.getCreated() }}</td>
            <td>{{ user.getDeleted() }}</td>
            <td>{{ link_to("users/edit/"~user.getId(), "Edit") }}</td>
            <td>{{ link_to("users/delete/"~user.getId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("users/search", "First") }}</td>
                        <td>{{ link_to("users/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("users/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("users/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
