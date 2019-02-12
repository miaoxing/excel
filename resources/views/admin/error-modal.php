<script id="import-error-tpl" type="text/html">
  <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="import-modal-label">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="authorizeModalLabel">上传失败结果</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="well form-well m-b">
            <form class="form-horizontal">
              <div class="form-group m-b-0">
                <label class="col-md-3 control-label">总记录数：</label>

                <div class="col-md-1">
                  <p class="form-control-static">
                    <%= totalCount %>
                  </p>
                </div>

                <label class="col-md-3 control-label">新增记录：</label>

                <div class="col-md-1">
                  <p class="form-control-static">
                    <%= createCount %>
                  </p>
                </div>

                <label class="col-md-3 control-label">更新记录：</label>

                <div class="col-md-1">
                  <p class="form-control-static">
                    <%= updateCount %>
                  </p>
                </div>
              </div>
            </form>
          </div>

          <table class="table table-bordered">
            <thead>
            <tr>
              <th>记录ID</th>
              <th>错误码</th>
              <th>错误信息</th>
            </tr>
            </thead>
            <tbody>
            <% for(var i in errors) { %>
            <tr>
              <td><%= errors[i].id %></td>
              <td><%= errors[i].code %></td>
              <td><%= errors[i].message %></td>
            </tr>
            <% } %>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
        </div>
      </div>
    </div>
  </div>
</script>
