<?php include "includes/admin_header.php" ?>
<div id="wrapper">



  <!-- Navigation -->
  <?php include "includes/admin_navigation.php"?>

  <div id="page-wrapper">

    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">
            Welcome to admin
            <small>
              <?php echo $_SESSION['username']; ?>
            </small>
          </h1>
        </div>
      </div>
      <!-- /.row -->


      <!-- /.row -->

      <div class="row">
        <div class="col-lg-3 col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-3">
                  <i class="fa fa-file-text fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">

                  <div class='huge'>
                    <?php echo $post_count = recordCount('posts'); ?>
                  </div>

                  <div>Posts</div>
                </div>
              </div>
            </div>
            <a href="posts.php">
              <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right">
                  <i class="fa fa-arrow-circle-right"></i>
                </span>
                <div class="clearfix"></div>
              </div>
            </a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="panel panel-green">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-3">
                  <i class="fa fa-comments fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">

                  <div class='huge'>
                    <?php echo $comment_count = recordCount('comments'); ?>
                  </div>
                  <div>Comments</div>
                </div>
              </div>
            </div>
            <a href="comments.php">
              <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right">
                  <i class="fa fa-arrow-circle-right"></i>
                </span>
                <div class="clearfix"></div>
              </div>
            </a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="panel panel-yellow">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-3">
                  <i class="fa fa-user fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                  <div class='huge'>
                    <?php echo $user_count = recordCount('users'); ?>
                  </div>
                  <div> Users</div>
                </div>
              </div>
            </div>
            <a href="users.php">
              <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right">
                  <i class="fa fa-arrow-circle-right"></i>
                </span>
                <div class="clearfix"></div>
              </div>
            </a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="panel panel-red">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-3">
                  <i class="fa fa-list fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                  <div class='huge'>
                    <?php echo $category_count = recordCount('categories'); ?>
                  </div>
                  <div>Categories</div>
                </div>
              </div>
            </div>
            <a href="categories.php">
              <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right">
                  <i class="fa fa-arrow-circle-right"></i>
                </span>
                <div class="clearfix"></div>
              </div>
            </a>
          </div>
        </div>
      </div>
      <!-- /.row -->


      <?php 
        $posts_draft_count = checkStatus('posts', 'post_status', 'draft'); 
        $posts_published_count = checkStatus('posts', 'post_status', 'published');
        $unapproved_comment_count = checkStatus('comments', 'comment_status', 'unapproved');
        $subscriber_count = checkStatus('users', 'user_role', 'subscriber');
        ?>


      <div class="row">
        <script type="text/javascript">
          google.charts.load('current', {
            'packages': ['bar']
          });
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Data', 'Count'],

              <?php 

              $elements_text = ['All Posts', 'Active Posts', 'Draft Posts', 'Comments', 'Pending Comments', 'Users', 'Subscribers', 'Categories'];
              $elements_count = [$post_count, $posts_published_count, $posts_draft_count, $comment_count, $unapproved_comment_count, $user_count, $subscriber_count, $category_count];

              for($i = 0; $i < 7; $i++) {
                echo "['{$elements_text[$i]}'" . "," ."{$elements_count[$i]}],";
              }

            ?>

              /*           ['Posts', 1000] */
            ]);

            var options = {
              chart: {
                title: '',
                subtitle: '',
              }
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
          }
        </script>

        <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
      </div>

    </div>
    <!-- /.container-fluid -->

  </div>

  <!-- /#page-wrapper -->

  <?php include "includes/admin_footer.php" ?>

<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
  $(document).ready(function() {
    var pusher = new Pusher('e9929dfd07dba8520401', {
      cluster: 'eu',
      encrypted: true
    });

    var notificationChannel = pusher.subscribe('notifications');
    notificationChannel.bind('new_user', function(notification) {

      var message = notification.message;

      toastr.success(`${message} just registered.`);

    });

  });
</script>