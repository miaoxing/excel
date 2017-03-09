define(['jquery-form'], function () {
  var importExcel = {};

  // 上传文件到服务器
  var submit = $.fn.ajaxSubmit;
  $.fn.uploadFile = function (url, cols, call) {
    return submit.call(this, {
      dataType: 'json',
      type: 'post',
      data: {cols: cols},
      url: $.url('admin/excel/uploadAndParseToJson'),
      success: function (result) {
        if (result.code < 0) {
          $.err(result.message, 5000);
        } else {
          $.info('文件上传成功,解析中...', 60000);
          $.tips.hideAll();
          $.msg(result, function() {
            if (result.code > 0) {
              importExcel.loadData(result.data, url, call);
            }
          });
        }
      }
    });
  };

  // 将数据填充到表格中
  importExcel.loadData = function (data, url, call) {
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: $.url(url),
      data: {data: data},
      success: function (result) {
        call(result);
      },
      error: function (result) {
        call(result);
      }
    });
  };
});

