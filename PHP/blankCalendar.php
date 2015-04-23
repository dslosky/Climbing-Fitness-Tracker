<?php

                            for ($i = 1; $i <= 14; $i++) {
                                echo '<div class="row calRow">
                                        <div class="col-xs-2"></div>
                                        <div class="col-xs-2">
                                            <h3>Week ' . $i . '</h3>
                                        </div>';

                                for ($j = 1; $j <= 7; $j++) {

                                    echo '<div class="col-xs-1">
                                            <div class="calDay day' . $j . 'week' . $i . '">
                                                <div class="dayInfo" style="opacity: 0;">
                                                    <p>date</p>
                                                </div>
                                                <div class="workoutTitle" style="opacity: 0;">
                                                    <h3>Workout</h3>
                                                </div>
                                                <div class=dayDate>
                                                </div>
                                                <div class="caldayGradbottom">
                                                </div>
                                                <div class="caldayGradtop">
                                                </div>
                                                <div class="caldayGradleft">
                                                </div>
                                                <div class="caldayGradright">
                                                </div>
                                            </div>
                                         </div>';
                                }

                                echo '</div>';
                                echo '<div class="row calSpacer">
                                        <div class="col-xs-12"><p> </p></div>
                                      </div>';
                                
                                echo '<div class="row calSpacer"></div>';

                            }

?>