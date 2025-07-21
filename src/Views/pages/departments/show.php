<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="jumbotron bg-primary text-white p-5 rounded mb-4">
                <div class="mt-4">
                    <?php
                    if (!empty($department)): ?>
                        <h1 class="display-4"><?php
                            echo htmlspecialchars($department->getName()); ?></h1>
                        <div>
                            <a href="/departments/<?php
                            echo $department->getId(); ?>/edit" class="btn btn-warning btn-lg mr-2">Change</a>
                            <form method="post" action="/departments/<?php
                            echo $department->getId(); ?>/delete" style="display:inline;"
                                  onsubmit="return confirm('Are you sure?');">
                                <input type="hidden" name="id" value="<?php
                                echo $department->getId(); ?>">
                                <button type="submit" class="btn btn-danger btn-lg">Delete</button>
                            </form>
                            <a class="btn btn-outline-light btn-lg" href="/departments/create" role="button">Add new</a>
                        </div>
                    <?php
                    else: ?>
                        <p>There isn't data to show</p>
                    <?php
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

