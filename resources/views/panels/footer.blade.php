<style>
.footer_widget {
    height: 70px;
    position: relative;
}
.card_footer {
    background: #fff;
    border-radius: 3px;
    border: 1px solid #e0e5e5;
    padding: 5px;
    height: 100%;
    width: 100%;
    overflow: auto;
}
.card_footer:hover {
  position: absolute;
  bottom: 0;
  left:0;
  right:0;
  z-index: 99;
  min-height: 70px;
  overflow: unset!important;
  height: fit-content;
  max-height:600px;
}
.card_footer .card_details {
  display: none;
  background: #f5f5f5;
  border-radius: 3px;
  border: 1px solid #ededed;
  padding: 5px;
  margin-top: 8px;
}
.card_footer:hover .card_details {
  display: revert!important;
}
.card_footer_show {
  position: absolute;
  bottom: 0;
  z-index: 99;
}
</style>
<footer class="footer footer-light @if(isset($configData['footerType'])){{$configData['footerClass']}}@endif">
  <div style="padding: 5px;white-space: nowrap;">
  <div class="row">
    <div class="col-3">
      <div class="footer_widget">
      <div class="card_footer">
      <!-- Card 01 -->
<div class="todo_block">
  <div class="todo_block_btn" onclick="javascript:todo_add();">Solicitar</div>
  <div>
    <table>
      <thead onclick="javascript:todo_mini();;">
        <th>De</th>
        <th>Petición</th>
        <th>Link</th>
        <th>Para</th>
        <th>Estado</th>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>
      <!-- Card 01 -->
      </div>
      </div>
    </div>
    <div class="col-3">
      <div class="footer_widget">
        <div class="card_footer" data-widget="actividad"></div>
      </div>
    </div>
    <div class="col-3">
      <div class="footer_widget">
        <div class="card_footer">
          <div data-block-dinamic="/dashboard/part/competencias" data-block-auto="true"></div>
        </div>
      </div>
    </div>
    <div class="col-3">
      <div class="footer_widget">
        <div class="card_footer">
          <div data-block-dinamic="/dashboard/part/actividades" data-block-auto="true"></div>
        </div>
      </div>
    </div>
  </div>
  </div>
</footer>
