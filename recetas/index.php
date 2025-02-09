<?php

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

include_once $_SERVER['DOCUMENT_ROOT']."/config/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config/config.php";
$page = $t["config"]["page_recetas"];
include_once $_SERVER['DOCUMENT_ROOT']."../inc/header.php";

?>
<div class="page-content">
    <h2 class=""><?php echo $t["recetas"]["receta"] ?></h2>
    <?php AddReceta($t);  ?>
    <?php
    // Attempt select query execution
    $sql = "SELECT * FROM recetas";
    if ($result = $pdo->query($sql)) {
        if ($result->rowCount() > 0) {
            echo "<div class='recetas-content'>";
            while ($row = $result->fetch()) {
                ?>
    <div class="content" style="margin: 2rem auto; max-width: 60%; ">
        <div class="">
            <a href="show-receta.php?id=<?php echo $row['receta_id']; ?>"><?php echo $row['receta_name']; ?></a>
        </div>
        <div class="cats-here">
            <?php
            $cat_id = $row['recetas_cat_id'];
                $s_cats = "SELECT * From cats WHERE cat_id = $cat_id";
                if ($cats_result = $pdo->query($s_cats)) {
                    if ($cats_result->rowCount() > 0) {
                        while ($cats = $cats_result->fetch()) { ?>
            <div cat_link>
                <a href="../categorias/show-categorias.php?id=<?php echo $cats['cat_id']?>">
                    <?php echo $cats['cat_name']?>
                </a>
            </div>

            <?php
                        }
                    }
                    unset($cats_result);
                } ?>
        </div>
        <div class=""><?php echo $row['receta_desc']; ?></div>
        <div class="cats-img-wrapper"><img src="../uploads/recetas/<?php echo $row['receta_img'] ?>" width="50"
                height="50" style="object-fit: cover;"></img> </div>
        <?php
                $user_id = $row['recetas_author_id'];
                $s_author = "SELECT * From users WHERE user_id = $user_id";
                if ($author_result = $pdo->query($s_author)) {
                    if ($author_result->rowCount() > 0) {
                        while ($author = $author_result->fetch()) { ?>
        <div class="author_link">
            <a href="recetas-author.php?id=<?php echo $author['user_id']?>">
                <?php echo $author['user_name']?>
            </a>
        </div>
        <?php
                        }
                    }
                    unset($author_result);
                } ?>
        <!-- aqui tiene que estar el menu de acciones  -->
    </div>
    <?php
            }
            echo "</div> <!-- /receta-content -->";
            unset($result);
        } else {
            echo '<div class=""><em>' . $t["error"]["empty"] . '</em><a href="categorias-add.php" class="btn btn-success pull-right">' . $t["button"]["add_receta"] . '</a></div>';
        }
    } else {
        echo $t["error"]["admin"];
    }
    unset($pdo);
    ?>
</div>
<?php
include_once "../inc/footer.php";