<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="jumbotron bg-primary text-white p-5 rounded mb-4">
                <h1 class="display-4">List of Users</h1>
                <hr class="my-4">
                <div class="mt-4">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <div class="card mb-3">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <a href="/users/<?php echo $user['id']; ?>"><span class="h5 mb-0"><?php echo htmlspecialchars($user['name']); ?></span></a>
                                    <div>
                                        <a href="/users/<?php echo $user['id']; ?>/edit" class="btn btn-warning btn-sm mr-2">Change</a>
                                        <form method="post" action="/users/<?php echo $user['id']; ?>/delete" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>There aren't users to show.</p>
                    <?php endif; ?>

                    <a class="btn btn-outline-light btn-lg" href="/users/create" role="button">Add new</a>
                </div>
            </div>
        </div>
    </div>
</div>

