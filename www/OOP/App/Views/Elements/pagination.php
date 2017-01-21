<?php

    function getPreviousPageRoute($sortBy, $activePage, $sortTurn){
        $href = getRout() . '?';
        $href .= 'sortBy=' . $sortBy . '&';
        $href .= 'activePage=';

        $tempPage = (intval($activePage));
        if ($tempPage > 1) {
            $href .= (intval($activePage) - 1) . '&';
        }else{
            $href .= '1&';
        };

        $href .= 'sortTurn=' . $sortTurn;

        return $href;
    };

    function getPageRoute($sortBy, $tempPage, $sortTurn){
        $href = getRout() . '?';
        $href .= 'sortBy=' . $sortBy . '&';
        $href .= 'activePage=' . $tempPage . '&';
        $href .= 'sortTurn=' . $sortTurn;

        return $href;
    };

    function getNextPageRoute($sortBy, $activePage, $maxPages, $sortTurn){
        $href = getRout() . '?';
        $href .= 'sortBy=' . $sortBy . '&';
        $href .= 'activePage=';

        $tempPage = (intval($activePage));
        if ($tempPage >= $maxPages) {
            $href .= $maxPages . '&';
        }else{
            $href .= (intval($activePage) + 1) . '&';
        };

        $href .= 'sortTurn=' . $sortTurn;

        return $href;
    };

?>

<!--
##########################
### Start of html code ###
##########################
-->

<div class="pagination-block">
    <div class="previous-a">
        <?php 
            if ($activePage != 1): 
        ?>
            <a href='<?php echo getPreviousPageRoute($sortBy, $activePage, $sortTurn) ?>'>                
                <div class="previous-img"></div>                
                <p>previous</p>
            </a>
        <?php endif; ?>
    </div>
    <div class="pages-block">
        <div>
            <p>page: </p>

            <?php
            $temp = 1;
            $maxPages = ceil($numberOfAllFields/$maxOnPage);
            while ($temp <= $maxPages): ?>
                <a <?php echo ($temp == $activePage)
                            ? "style='color:white'"
                            : null; ?>
                    href='<?php echo getPageRoute($sortBy, $temp, $sortTurn) ?>'><?php echo $temp?></a>
            <?php
                $temp++;
            endwhile; 
            ?>
        </div>
    </div>
    <div class="next-a">
        <?php if ($maxPages != $activePage): ?>
            <a href='<?php echo getNextPageRoute($sortBy, $activePage, $maxPages, $sortTurn) ?>'>
                <p>next</p>
                <div class="next-img"></div>
            </a>
        <?php endif; ?>
    </div>
</div>