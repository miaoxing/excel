define(['plugins/app/libs/jquery-form/jquery.form'], function () {
  var importExcel = {};

  var delayLong = 5000;
  var delayLonger = 60000;

  // 上传文件到服务器
  var submit = $.fn.ajaxSubmit;
  $.fn.uploadFile = function (url, cols, call) {
    return submit.call(this, {
      dataType: 'json',
      type: 'post',
      loading: true,
      data: {cols: cols},
      url: $.url('admin/excel/uploadAndParseToJson'),
      success: function (result) {
        if (result.code !== 1) {
          $.alert(result.message);
          return;
        }

        $.msg(result);
        importExcel.loadData(result.data, url, call);
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
      }
    });
  };
});
