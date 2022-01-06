{% for entry in arr_prods.products %}
<li{% if blush %} class="blush"{% endif %}>
    <div>
        <div class="pTitle">id:{{ entry.data.prod_id }}, {{ entry.data.prod_name | upper }} (index: {{ loop.index }})</div>
        <div class="pImg">
            {% for pic in entry.pics %}
            <a href="/img/products/{{ pic.pp_prod_id }}/{{ pic.pp_name }}" target="_blank"><img style="{% if loop.index > 1 %} display: none; {% endif %}" src="/img/products/{{ pic.pp_prod_id }}/thumbs/{{ pic.pp_name }}"></a>
            {% else %}
            <img src="/img/system/no_photo_64.png">
            {% endfor %}
            </div>
            <div class="pPrice">{{ entry.data.prod_price }} руб.</div>
        <div class="pDesc">{{ entry.data.prod_desc }}</div>
    </div>
</li>
{% endfor %}
