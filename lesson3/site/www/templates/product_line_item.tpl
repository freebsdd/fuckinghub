<tr>
    <td style="text-align: center;">
        {% for pic in entry.pics %}
            <a href="/img/products/{{ pic.pp_prod_id }}/{{ pic.pp_name }}"><img style="max-height: 45px; max-width: 45px;" src="/img/products/{{ pic.pp_prod_id }}/thumbs/{{ pic.pp_name }}"></a>
        {% else %}
            <img style="max-height: 45px; max-width: 45px;" src="/img/system/no_photo_64.png">
        {% endfor %}
    </td>
    <td><span style="font-size: 90%;">{{ entry.data.prod_name | upper }}</span><div style="font-size: 80%; opacity: 0.6;">{{ entry.data.prod_desc }}</div></td>
</tr>