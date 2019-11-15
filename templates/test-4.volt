{% extends 'test-4-template.volt' %}

{% block body %}
    <main role="main">
        {% for index in 0..100 %}
            {{ partial("partials/content/content_with_index.volt", ['index': index]) }}
        {% endfor %}
    </main>
{% endblock %}

{% block footer %}
    {% include "partials/footer.volt" %}
{% endblock %}