<?php
global $wp_the_query;

$post_id = $wp_the_query->get_queried_object_id();
$assets = get_field( 'assets', $post_id );

foreach ( $assets as $key => $asset ) {
  $args = array(
    'post_type' => 'asset',
    'numberposts' => 1,
    'name' => $asset['symbol'],
  );

  $asset_id = get_posts( $args )[0]->ID;
  $assets[$key]['returns'] = json_decode( get_field( 'returns', $asset_id ) );
  $assets[$key]['name'] = get_post_field( 'post_content', $asset_id );
}
?>

<div class="main">
      <div class="container">
        <nav class="main-nav">
          <div class="logo">
            <img src="<?php echo bloginfo('stylesheet_directory'); ?>/img/vesple.svg" alt="Image">
          </div> <!-- .logo -->
          <div class="nav-menu">
            <ul>
              <li>
                <form action="<?php echo home_url('/wp-admin/admin-post.php'); ?>" method="post">
                  <input type="hidden" name="action" value="create_portfolio">
                  <button type="submit" class="create-portfolio">
                    <span class="icon-create-portfolio"></span>Create Portfolio
                  </button>
                </form>
              </li>
              <li>
                <a href="<?php echo wp_logout_url(); ?>" class="user-logout" id="logout">
                  <span class="icon-logout m-r-10"></span>Sign out
                </a>
              </li>
            </ul>
          </div>
        </nav> <!-- .main-nav -->
      </div>
    </div> <!-- .main -->
    <div class="portfolios">
      <div class="container">
        <div class="portfolio-buttons">
          <?php

          $this_post_id = get_the_id();

          $args = array(
          	'post_type' => 'portfolio',
          	'numberposts' => -1,
          	'post_status' => 'publish',
          	'author' => get_current_user_id(),
          	'orderby' => 'post_title',
          	'order' => 'ASC',
          );

          $query = new WP_Query( $args );

          if ( $query->have_posts() ) {
          	while ( $query->have_posts() ) {
          		$query->the_post();
          		$class = get_the_id() === $this_post_id ? 'btn-secondary' : 'btn-empty';
          		?>
              <a href="<?php the_permalink(); ?>" class="btn <?php echo $class; ?> btn-small caps m-b-20"><?php the_title(); ?></a>
          		<?php
          	}
          }
          ?>
        </div>
        <div class="card">
          <div class="header desktop m-t-50 m-b-80">
            <div class="left">
              <h1 class="label-l2"><?php echo get_the_title( $post_id ); ?></h1>
              <span class="date m-l-20 label-s2"><?php echo get_the_date( 'F j, Y', $post_id ); ?></span>
            </div>
            <div class="right">
              <a href="/portfolio/<?php echo $post_id; ?>/assets" id="edit" class="btn btn-primary btn-small">Update portfolio</a>
              <div class="settings-icon m-l-20">
                <span id="toggle-settings" class="icon-settings"></span>
                <div class="settings-dropdown">
                  <?php global $post; ?>
                  <form action="<?php echo home_url('/wp-admin/admin-post.php'); ?>" method="post">
                    <input type="hidden" name="action" value="delete_portfolio">
                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                    <button type="submit" class="label-m1 dark" id="delete-portfolio">Delete portfolio</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="header mobile m-t-50 m-b-80">
            <div class="left">
              <h1 class="label-l2"><?php echo get_the_title( $post_id ); ?></h1>
              <a href="/wizard/{{_id}}/assets" id="edit" class="btn btn-primary btn-small">Edit</a>
            </div>
            <div class="right">
              <span class="date m-l-20 label-s2"><?php echo get_the_date( 'Y-m-d', $post_id ); ?></span>
              <a href="#" class="settings-icon m-l-20">
                <span id="toggle-settings" class="icon-settings"></span>
                <div class="settings-dropdown">
                  <form action="<?php echo home_url('/wp-admin/admin-post.php'); ?>" method="post">
                    <input type="hidden" name="action" value="delete_portfolio">
                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                    <button type="submit" class="label-m1 dark" id="delete-portfolio">Delete portfolio</button>
                  </form>
                </div>
              </a>
            </div>
          </div>
          <?php if ( sizeof( $assets )  > 0 ): ?>
            <div class="overview-box">
              <table>
                <tr>
                  <th>SYMBOL</th>
                  <th>NAME</th>
                  <th>QUANTITY</th>
                </tr>
                <?php foreach ($assets as $key => $asset) {
                  ?>
                  <tr>
                    <td><?php echo $asset['symbol']; ?></td>
                    <td><?php echo $asset['name']; ?></td>
                    <td><?php echo $asset['quantity']; ?></td>
                  </tr>
                  <?php
                } ?>
              </table>
              <div>
                <div id="portfolio-distribution">

                </div>
                <div class="legend5">

                </div>
              </div>
            </div>
          <?php endif; ?>
          <!-- <h1 class="label-l2 m-t-100 p-l-40 m-b-50">Performance atual</h1>
          <div class="current-performance-chart m-b-100 p-b-40">
            <ul>
              <li>
                <div class="label-s1 light caps">
                  Total investido
                </div>
                <div class="label-l1 dark bold">
                  R$57321
                </div>
              </li>
              <li>
                <div class="label-s1 light caps">
                  ganho total
                </div>
                <div class="label-l1 dark bold">
                  9,5%
                </div>
              </li>
              <li>
                <div class="label-s1 light caps">
                  valor da carteira
                </div>
                <div class="label-l1 dark bold">
                  R$65021
                </div>
              </li>
            </ul>
            <div class="chart-wrapper">
              <div id="chart2Legend">

              </div>
              <div id="chart2">
              </div>
              <div id="chart2X">

              </div>
            </div>
          </div> -->
          <?php if ( get_field('current_average_monthly_return', $post_id) ): ?>
          <h1 class="label-l2 m-t-100 p-l-40 m-b-50">Expected performance</h1>
          <ul class="performance-items">
            <li>
              <div class="performance-item-content">
                <div class="label-l1 dark bold m-b-10">$<?php echo number_format(get_field('portfolio_value', $post_id), 0); ?></div>
                <div class="label-s2 light caps">
                  portfolio value
                </div>
              </div>
              <span class="icon-investment-circle"><span class="path1"></span><span class="path2"></span></span>
            </li>
            <li id="investment-period">
              <div class="performance-item-content">
                <span class="label-l1 dark bold m-r-10"><div class="investment-period" contenteditable="true">5</div>Years</span><span class="icon-edit"></span>
                <div class="label-s2 light caps m-t-10">
                  Simulation period
                </div>
              </div>
              <span class="icon-period-circle"><span class="path1"></span><span class="path2"></span></span>
            </li>
            <li>
              <div class="performance-item-content">
                <div class="regular-investment m-b-10">
                  <span class="label-l1 dark bold">$<?php echo get_field('investment_amount', $post_id); ?></span><span class="label-s1 bold dark m-l-10">Every<br><?php echo get_field('investment_interval', $post_id); ?> months</span>
                </div>
                <div class="label-s2 light caps">
                  Regular investment
                </div>
              </div>
              <span class="icon-regular-amount-circle"><span class="path1"></span><span class="path2"></span></span>
            </li>
            <li class="dividend-yield">
              <div class="performance-item-content">
                <div class="label-l1 dark bold m-b-10"><?php echo get_field('inflation', $post_id); ?>%</div>
                <div class="label-s2 light caps">
                  inflation
                </div>
              </div>
              <span class="icon-dividend-circle"><span class="path1"></span><span class="path2"></span></span>
            </li>
          </ul>
          <div class="current-performance-chart">
            <ul>
              <li>
                <div class="label-s1 light caps">
                  Average return
                </div>
                <div class="label-l1 dark bold">
                  <?php echo number_format(get_field('current_average_monthly_return', $post_id) * 100, 2); ?>%
                </div>
                <div class="label-s1 dark bold">
                  / month + dividends
                </div>
              </li>
            </ul>
            <div class="chart-wrapper">
              <div id="chart3Legend">

              </div>
              <div id="chart3">
              </div>
              <div id="chart3X">

              </div>
              <div class="chart1-disclaimer label-s2 light align-right m-t-30 m-b-20">
                Expected results are based on past performance and are not a guarantee of future performance.
              </div>
            </div>
          <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
