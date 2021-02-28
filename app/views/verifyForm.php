
<?php $this->layout('layout', ['title' => 'User Profile']) ?>

<div class="container">
    <div class=" row col-md-6">
        <form  action="/verify" method="POST">
            <div class="form-group">
                <label class="form-label" for="">Selector</label>
                <input type="text"  class="form-control" placeholder="Selector" name="selector" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="">Token</label>
                <input type="text"  class="form-control" placeholder="Token" name="token" required>
            </div>
            <div class="form-group">
                <button  type="submit" class="btn btn-block btn-success btn-lg mt-3">Submit</button>
            </div>
        </form>
    </div>
</div>
