<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="jumbotron bg-primary text-white p-5 rounded mb-4">
                <h1 class="display-4">List of Departments</h1>
                <hr class="my-4">
                <div class="mt-4">
                    <?php if (!empty($departments)): ?>
                        <?php foreach ($departments as $department): ?>
                            <div class="card mb-3">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <a href="/departments/<?php echo $department['id']; ?>"><span class="h5 mb-0"><?php echo htmlspecialchars($department['name']); ?></span></a>
                                    <div>
                                        <a href="/departments/<?php echo $department['id']; ?>/edit" class="btn btn-warning btn-sm mr-2">Change</a>
                                        <form method="post" action="/departments/<?php echo $department['id']; ?>/delete" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                            <input type="hidden" name="id" value="<?php echo $department['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>There aren't departments to show.</p>
                    <?php endif; ?>

                    <a class="btn btn-outline-light btn-lg" href="/departments/create" role="button">Add new</a>
                </div>
            </div>
        </div>
    </div>
</div>

