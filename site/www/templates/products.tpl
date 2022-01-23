<div id="prod_list" class="prod_list">
{% if arr_prods.products %}
    <ul class="prods">
    {% include 'product_line_item.tpl' %}
    </ul>
    <div class="" style="padding: 5px; border: 1px solid #c7c7c7; width: 100%; text-align: center; font-weight: bold; font-size: 110%;"><a class="prod_act" data-fields="pl=site##action=load_more">load more</a></div>
{% else %}
    <div>Товары не найдены!</div>
{% endif %}
</div>