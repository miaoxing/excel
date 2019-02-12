<script id="import-suc-tpl" type="text/html">
  <div class="modal fade" id="suc-modal" tabindex="-1" role="dialog" aria-labelledby="import-modal-label">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="authorizeModalLabel">上传成功结果</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered">
            <thead>
            <tr>
              <th>总数量</th>
              <th>新增数量</th>
              <th>更新数量</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td><%= totalCount %></td>
              <td><%= createCount %></td>
              <td><%= updateCount %></td>
            </tr>
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
