<div class="container my-4">
    <h1 class="mb-4">Top 10 Volunteers in Volunteer Hours</h1>
    <div class="accordion" id="volunteerAccordion">
        <?php 
        $counter = 1;
        foreach ($volunteers as $volunteer):
            // يسوي سطر جديد لكل ثلاث عناصر
            if ($counter % 3 == 1) {
                echo '<div class="row">';
            }
        ?>
            <!-- حجم المتطوع -->
            <div class='col-md-4'> 
                <div class='accordion-item mb-4'>
                    <!-- الراس والجسم حق المتطوع مربوطة بالعداد -->
                    <h2 class='accordion-header' id='heading<?php echo $counter; ?>'>
                        <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse'
                            data-bs-target='#collapse<?php echo $counter; ?>' aria-expanded='false'
                            aria-controls='collapse<?php echo $counter; ?>'>
                            <?php echo "#".ordinal($counter)." ".htmlspecialchars($volunteer['name']) ?>
                        </button>
                    </h2>
                    <div id='collapse<?php echo $counter; ?>' class='accordion-collapse collapse'
                        aria-labelledby='heading<?php echo $counter; ?>' data-bs-parent='#volunteerAccordion'>
                        <div class='accordion-body'>
                            <div class='card'>
                                <div class='card-body'>
                                    <h5 class='card-title'><?php echo htmlspecialchars($volunteer['name']) ?></h5>
                                    <p class='card-text'><strong>Skills:</strong>
                                        <?php echo htmlspecialchars($volunteer['skills']) ?>
                                    </p>
                                    <p class='card-text'><strong>Rate:</strong>
                                        <?php echo htmlspecialchars($volunteer['rate']) ?>
                                    </p>
                                    <p class='card-text'><strong>Volunteering Opportunity:</strong>
                                        <?php echo htmlspecialchars($volunteer['number_v']) ?>
                                    </p>
                                    <p class='card-text'><strong>Volunteering Hours:</strong>
                                        <?php echo htmlspecialchars($volunteer['volunteering_hours']) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
            // يقفل السطر لما ينتهي من الثلاثة اللي في السطر او تنتهي المصفوفة
            if ($counter % 3 == 0 || $counter == count($volunteers)) {
                echo '</div>'; // تقفيلة السطر
            }
            $counter++; 
        endforeach; 
        ?>   
    </div>
</div>