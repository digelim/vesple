<?php global $post; ?>
<form action="<?php echo home_url('/wp-admin/admin-post.php'); ?>" method="post">
  <input type="hidden" name="action" value="add_assets_to_portfolio">
  <input type="hidden" name="post_id" value="<?php echo $post->ID; ?>">
  <div class="steps-overlay">
    <nav class="steps-bar">
      <div class="left">
        <a href="<?php the_permalink(); ?>" class="tab" id="steps-close">
          <span class="icon-delete"></span>
        </a>
        <a class="tab active" id="tab-1">
          <span class="icon-assets-tab"></span>
          <span class="tab-label">assets</span>
        </a>
        <button type="submit" class="tab" id="tab-2">
          <span class="icon-investment-tab"></span>
          <span class="tab-label">investment</span>
        </button>
        <a class="tab" id="tab-3">
          <span class="icon-portfolio-tab"></span>
          <span class="tab-label">portfolio</span>
        </a>
      </div>
      <div class="right">
        <button type="submit" class="btn btn-next-step">Set investment<span class="icon-next-tab"><span class="path1"></span><span class="path2"></span></span></button>
      </div>
    </nav>
    <div class="container">
        <div class="group material-design with-icon assets-search">
          <input class="form-control typeahead" autocomplete="off" data-limit="10" spellcheck="off" name="assets"
           data-source="assets" data-template="assets_suggestion" data-value-key="name" type="text" placeholder="Add your favorite stocks, crypto or currencies" data-select="select"/>
          <span class="icon-input-search"></span>
          <span class="bar"></span>
          <!-- <div class="tags-list">
            <a class="tag" href="#">dividendos</a>
            <a class="tag" href="#">setor elétrico</a>
            <a class="tag" href="#">setor farmacêutico</a>
            <a class="tag" href="#">setor bancário</a>
            <a class="tag" href="#">setor de educação</a>
            <a class="tag" href="#">maiores altas</a>
            <a class="tag" href="#">maiores baixas</a>
            <a class="tag" href="#">ibovespa</a>
            <a class="tag" href="#">setor de consumo</a>
          </div> -->
        </div>
        <!-- <div class="assets-alternate align-center">
          <div class="m-b-30 label-m1 dark">ou</div>
          <a class="btn-primary btn-small" href="#">Me dê sugestões</a>
        </div> -->
        <div class="assets-list">
          <ul>
            <script type="text/html" id="tmpl-assets-list">
              <li id="item-{{{data.symbol}}}">
                <div class="assets-item">
                  <input type="hidden" name="symbols[]" value="{{{data.symbol}}}">
                  <div class="asset-chart" id="a-{{{data.symbol}}}"></div>
                  <div class="top">
                    <span class="label-l2 dark caps m-b-5">{{{data.symbol}}}</span>
                    <span class="label-s2 light">{{{data.name}}}</span>
                    <a href="#" data-remove="item-{{data.symbol}}" class="remove-asset">
                      <span class="icon-delete"></span>
                    </a>
                  </div>
                  <div class="bottom">
                    <div class="left">
                      <span class="label-s1 light">{{{data.currency}}}</span>
                    </div>
                    <div class="right">
                      <span class="label-m1 dark">${{{data.close}}}</span>
                      <span class="label-s1" style="color: {{{data.color}}};">{{{data.signal}}}{{{data.change}}}% (${{{data.cents}}})</span>
                    </div>
                  </div>
                </div>
                <div class="add-shares-btn" data-symbol="{{{data.symbol}}}" data-asset-id="{{{data.symbol}}}" id="edit-shares-{{data.symbol}}">
                  <span class="label-m1 dark"><b>{{data.quantity}}</b></span>
                  <input type="hidden" name="stock-quantity[]" value="{{data.quantity}}">
                  <span class="icon-edit m-l-10" style="margin-right: -15px"></span>
                  <div class="label-s1 light caps m-t-5">shares</div>
                </div>
              </li>
            </script>
          </ul>
        </div>
      </div>
      <svg height="10" width="10" xmlns="http://www.w3.org/2000/svg" version="1.1">
        <defs>
          <pattern id="diagonal-stripe-1" patternUnits="userSpaceOnUse" width="6" height="6">
            <g id="Artboard-3-Copy-2" fill="#e1e7eb">
                <rect width="100%" fill="#eff4fe"></rect>
              <polygon id="Rectangle-9" points="5 0 6 0 0 6 0 5"></polygon>
              <polygon id="Rectangle-9-Copy" points="6 5 6 6 5 6"></polygon>
            </g>
         </pattern>
       </defs>
     </svg>
  </div>
  <div id="selected-assets">
  </div>
</form>
<script type="text/html" id="tmpl-selected-assets">
 <div class="assets-popup-overlay">
   <div class="assets-popup">
     <span class="icon-delete" id="close-assets-popup"></span>
     <h1 class="label-m1">How many shares do you own?</h1>
     <div class="group material-design popup-input-group">
       <input required="required" type="tel" name="stocks-amount" data-amount-symbol="{{{data.symbol}}}" value="{{data.quantity}}">
       <span class="bar"></span>
       <label>{{data.symbol}}</label>
     </div>
     <a href="#" class="btn btn-primary btn-small block" id="save-quantity-{{data.symbol}}">Save</a>
   </div>
 </div>
</script>
