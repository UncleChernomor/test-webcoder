<div class="container">
    <div class="row">
        <div class="col-12">
            <?php
            if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php
            endif; ?>
            <div class="jumbotron bg-primary text-white p-5 rounded mb-4">
                <h1 class="display-4">Create of User</h1>
                <hr class="my-4">
                <div class="mt-4">
                    <form method="post" action="/users">
                        <div class="row">
                            <label for="name" class="col-form-label col-2">Users name</label>
                            <input type="text" name="name" id="name" class="form-control col"
                                   placeholder="input name" minlength="2" maxlength="50">
                        </div>
                        <div class="row mt-2">
                            <label for="email" class="col-form-label col-2">Email</label>
                            <input type="email" name="email" id="email" class="form-control col"
                                   placeholder="input email">
                        </div>
                        <div class="row mt-2">
                            <label for="address-1" class="col-form-label col-2">Address Line 1</label>
                            <input type="text" name="address-1" id="address-1" class="form-control col"
                                   placeholder="input address">
                        </div>
                        <div class="row mt-2">
                            <label for="address-2" class="col-form-label col-2">Address Line 2</label>
                            <input type="text" name="address-2" id="address-2" class="form-control col"
                                   placeholder="input address">
                        </div>
                        <div class="row mt-2">
                            <label for="phone" class="col-form-label col-2">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control col"
                                   placeholder="input address"></div>
                        <div class="row mt-2">
                            <label for="comment" class="col-form-label col-2">Comment</label>
                            <textarea class="form-control col" name="comment" id="comment" rows="3" maxlength="200"></textarea>
                        </div>
                        <div class="row mt-2">
                            <?php
                            if (!empty($departments)): ?>

                                <label for="department" class="col-form-label col-2">Department</label>
                                <select name="department" id="department" class="form-select col">
                                    <option value="">Choose department</option>
                                    <?php
                                    foreach ($departments as $department): ?>
                                        <option value="<?= $department['id']; ?>">
                                            <?= htmlspecialchars($department['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php
                            else: ?>
                                <div class="alert alert-danger">No departments, we can't create new User</div>
                            <?php
                            endif; ?>
                        </div>
                        <div class="row mt-2">
                            <button type="submit" class="btn btn-outline-light btn-lg">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


