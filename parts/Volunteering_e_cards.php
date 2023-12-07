<div id="volunteerings" class="row">
    <?php foreach ($volunteering as $vo): ?>
        <!-- حيرجع كل واحد على شكل مصفوفة لوحده
                لما يخرج من قاعدة البيانات يخرج على شكل نص -->
        <div class="col-sm-12 col-md-6 col-lg-4 d-flex justify-content-center mb-4">
            <form class="" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="card h-100 shadow-sm" style="">
                    <img src="./../img/Default_volunteering.jpg" class="card-img-top img-fluid" alt="image">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo htmlspecialchars($vo["title"]); ?>
                        </h5>
                        <p class="card-text">
                            <?php echo htmlspecialchars($vo["description"]); ?>
                        </p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <?php echo "Start Date : " . htmlspecialchars($vo["start_date"]); ?>
                        </li>
                        <li class="list-group-item">
                            <?php echo "End Date : " . htmlspecialchars($vo["end_date"]); ?>
                        </li>
                        <li class="list-group-item">
                            <?php echo "Volunteer Hours : " . htmlspecialchars($vo["hours"]); ?>
                        </li>
                        <li class="list-group-item">
                            <?php echo "Required Skills : " . htmlspecialchars($vo["required_skills"]); ?>
                        </li>
                    </ul>

                    <button type="submit" name="completed_<?php echo htmlspecialchars($vo["id"]); ?>"
                        class="btn btn-outline-success m-1">Completed</button>
                    <button type="submit" name="view_<?php echo htmlspecialchars($vo["id"]); ?>"
                        class="btn btn-outline-secondary m-1" data-bs-toggle="modal"
                        data-bs-target="view&rate">View & Rate</button>
                    <button type="submit" name="delete_<?php echo htmlspecialchars($vo["id"]); ?>"
                        class="btn btn-outline-danger m-1"  >Delete</button>
                    
                    
                </div>
            </form>
        </div>
    <?php endforeach ?>
</div>