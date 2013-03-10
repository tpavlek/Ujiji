<?php
$adTypes = $page->getDB()->getAdTypes();
$categories = $page->getDB()->getCategories();
?>

<h3>Post Ad</h3>
<form action="process.php?type=post&method=create" method="POST" class="form-horizontal">
  <div class="control-group">
    <label class="control-label" for="atype">Type: </label>
    <div class="controls">
      <select name='atype'>
        <?php foreach ($adTypes as $type) {
            echo "<option value='" . $type . "'> " . $type . "</option>";
        } ?>
      </select>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Price: </label>
    <div class="controls">
      $<input type="number" name="price" />
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="title">Title: </label>
    <div class="controls">
        <input type="text" name="title" />
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="description">Description: </label>
    <div class="controls">
      <textarea name="description"></textarea>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="location">Location: </label>
      <div class="controls">
        <input type="text" name="location" />
      </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="category">Category: </label>
    <div class="controls">
  <select name='cat'>

    <?php
      $depth = 0;
      foreach($categories as $key => $value) {
        echo "<option value=" . $key . ">" . $key . "</option>";
          if (!empty($value)) {
              foreach ($value as $subcat) {
                  echo "<option value=" . $subcat . ">--" . $subcat . "</option>";
              }
          }

    } ?>
  </select>
    </div>
  </div>
    <input type="submit" value="Post ad" class="btn btn-success" />
</form>