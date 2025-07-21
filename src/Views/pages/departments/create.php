<div class="container">
    <div class="row">
        <div class="col-12">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <div class="jumbotron bg-primary text-white p-5 rounded mb-4">
                <h1 class="display-4">Create of department</h1>
                <hr class="my-4">
                <div class="mt-4">
                    <form method="post" action="/departments" class="d-flex flex-row align-items-center gap-2">
                        <label for="name-department" class="form-label">Name:</label>
                        <input type="text" name="name-department" id="name-department" class="form-control" placeholder="input name" minlength="2" maxlength="50">
                        <button type="submit" class="btn btn-success btn-md">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


