jQuery(document).ready(function ($) {
  $('body').on('click', '.load-policy', function () {
    let loadButton = $(this);
    loadButton.append('<div class="loader icon-after loading">');
    loadButton.append('<div class="show-policy"></div>');

    let data = {
      'action': 'send_bug_report',
      'report': $('.report-a-bug-message').val()
    };

    $.post(settings.ajaxurl, data, function (response) {
      loadButton.parent().find(".loading").removeClass("loading");
      loadButton.removeClass('load-policy');
      $('.show-policy').html(response.data);
    });
  });
});