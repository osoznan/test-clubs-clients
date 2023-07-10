let timer;

attachFilterHandlers = () => {
    let $form = $('#filter-form');

    $('input', $form).on("change", () => {
        $.pjax.reload({
            container: "#page_pjax",
            url: `${$form.attr('url')}?${$form.serialize()}`,
            replace: false
        });  //Reload GridView
    });
}
