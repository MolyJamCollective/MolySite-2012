    
    <footer class="footer">
      <p class="pull-right"><a href="#">Back to top</a></p>
      <p>Designed and built by <a href="http://www.frostedwolf.com" target="_blank">Zane Wolfgang Pickett</a> and the MolyJam organizers.</p>
    </footer>

  </div> <!-- /container -->
    
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./js/jquery.js"></script>
    <script src="./js/bootstrap-transition.js"></script>
    <script src="./js/bootstrap-alert.js"></script>
    <script src="./js/bootstrap-modal.js"></script>
    <script src="./js/bootstrap-dropdown.js"></script>
    <script src="./js/bootstrap-scrollspy.js"></script>
    <script src="./js/bootstrap-tab.js"></script>
    <script src="./js/bootstrap-tooltip.js"></script>
    <script src="./js/bootstrap-popover.js"></script>
    <script src="./js/bootstrap-button.js"></script>
    <script src="./js/bootstrap-collapse.js"></script>
    <script src="./js/bootstrap-carousel.js"></script>
    <script src="./js/bootstrap-typeahead.js"></script>
<?php
  for($i = 0; $i < sizeof($pageScripts); $i++)
  {
  echo "    <script src=\"".$pageScripts[$i]."\"></script>\n";
  }
?>

  </body>
</html>
