<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="jumbotron bg-primary text-white p-5 rounded mb-4">
                <div class="mt-4">
                    <?php
                    if (isset($user) && !empty($user)): ?>
                        <h1 class="display-4"> User: <?= htmlspecialchars($user['name']); ?></h1>
                        <dl class="row text-white">
                            <dt class="col-sm-3">ID</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($user['id'] ?? ''); ?></dd>

                            <dt class="col-sm-3">Email</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($user['email'] ?? ''); ?></dd>

                            <dt class="col-sm-3">Address</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($user['address'] ?? ''); ?></dd>

                            <dt class="col-sm-3">Phone</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($user['phone'] ?? ''); ?></dd>

                            <dt class="col-sm-3">Department ID</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($user['department_id'] ?? ''); ?></dd>

                            <?php if (!empty($user['comments'])): ?>
                                <dt class="col-sm-3">Comments</dt>
                                <dd class="col-sm-9"><?= nl2br(htmlspecialchars($user['comments'])); ?></dd>
                            <?php endif; ?>
                        </dl>

                        <div>
                            <a href="/users/<?= $user['id']; ?>/edit" class="btn btn-warning btn-lg mr-2 disabled">Change</a>
                            <form method="post" action="/users/<?= $user['id']; ?>/delete" style="display:inline;"
                                  onsubmit="return confirm('Are you sure?');">
                                <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-lg">Delete</button>
                            </form>
                            <a class="btn btn-outline-light btn-lg" href="/users/create" role="button">Add new</a>
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
