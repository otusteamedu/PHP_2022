<h1>Parentheses validator</h1>

<form method="POST" action="http://ashvedov.local:8005/parentheses/validate" enctype="multipart/form-data">
    <div>
        <input type="text" name="input_parentheses" placeholder="enter parentheses here">
    </div>

    <br>

    <div>
        <button type="submit">
            Validate
        </button>
    </div>

    @if ($validation_result)
    <br>

    <div>
        <span style="color:green">Parenthesis structure is valid</span>
    </div>
    @endif
</form>