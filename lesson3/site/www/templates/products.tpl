{% if arr_prods.products %}
    <table>
    {% for entry in arr_prods.products %}
        {% include 'product_line_item.tpl' %}
    {% endfor %}
    </table>
{% else %}
    <div>Товар не найден!</div>
{% endif %}