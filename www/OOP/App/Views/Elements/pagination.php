<div class="pagination-block">
    <div class="previous-a">
        <?php 
            if ($activePage != 1): 
        ?>
            <a href='<?php getRout() ?>?
                sortBy=<?php echo $sortBy?>&
                activePage=<?php $tempPage = (intval($activePage));
                        echo ($tempPage > 1) ? (intval($activePage) - 1) : 1;?>&
                sortTurn=<?php echo $sortTurn?>'>
                
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
                    href='<?php getRout() ?>?
                        sortBy=<?php echo $sortBy?>&
                        activePage=<?php echo $temp?>&
                        sortTurn=<?php echo $sortTurn?>'><?php echo $temp?></a>

                <?php
                $temp++;
            endwhile; ?>
        </div>
    </div>
    <div class="next-a">
        <?php
            if ($maxPages != $activePage): ?>
                <a href='<?php getRout() ?>?
                    sortBy=<?php echo $sortBy?>&
                    activePage=<?php $tempPage = (intval($activePage));
                    echo ($tempPage >= $maxPages) ? $maxPages : (intval($activePage) + 1);?>&
                    sortTurn=<?php echo $sortTurn?>'>
                    
                    <p>next</p>
                    <div class="next-img"></div>
                </a>
        <?php endif; ?>
    </div>
</div>