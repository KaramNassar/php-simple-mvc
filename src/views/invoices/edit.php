<form action="\invoices" method="post">
  <input type="hidden" name="_method" value="PUT">
  <label for="amount">Insert The invoice amount: </label>
  <input type="text" name="amount" id="amount" value="<?= $amount ?? '' ?>">
</form>