<form action="/expenses/{{ $expense->id }}" method="post" class="basic-form">
    @csrf

    @method('PUT');

    <div class="spacer">
        <label for="type">Expense Type</label>
        <p>Choose a Type</p>
        <select name="type" id="type" class="type-select @error('type') error @enderror">
            @foreach ($types as $type)
                <option value="{{ $type->id }}" @if($type->id == $expense->expense_type->id) selected="selected" @endif>{{ $type->title }}</option>
            @endforeach
        </select>
        <div class="multiple-choice" data-toggle=".type-select">
            @foreach($types as $type)
            <div class="option @if($type->id == $expense->expense_type->id) selected @endif" data-value="{{ $type->id }}">{{ $type->title }}</div>
            @endforeach
        </div>
    </div>

    <div class="spacer">
        <label for="title">Title</label>
        <p>Title your Expense</p>
        @error('title')
            <p class="form-error" role="alert">
                {{ $message }}
            </p>
        @enderror
        <input type="text" name="title" id="title" value="{{ $expense->title }}" @error('title') class="error" @enderror>
    </div>

    <div class="spacer">
        <label for="amount">Amount</label>
        <p>The paid Amount</p>
        @error('amount')
            <p class="form-error" role="alert">
                {{ $message }}
            </p>
        @enderror
        <input type="text" name="amount" id="amount" value="{{ $expense->amount }}" @error('amount') class="error" @enderror>
    </div>

    <div class="spacer">
        <label for="date">Date (mm/dd/yyyy)</label>
        <p>The Date of Purchase</p>
        @error('date')
            <p class="form-error" role="alert">
                {{ $message }}
            </p>
        @enderror
        <input type="text" name="date" id="date" value="{{ $expense->created_at->format('m/d/Y') }}" class="date-picker @error('date') error @enderror">
    </div>

        <input type="hidden" aria-hidden="true" name="current_timestamp" value="{{ \Carbon\Carbon::now() }}">

    <div class="spacer">
        <label for="description">Description</label>
        <p>You may add some details</p>
        @error('description')
            <p class="form-error" role="alert">
                {{ $message }}
            </p>
        @enderror
        <textarea name="description" id="description" rows="10" @error('description') class="error" @enderror>{{ $expense->description }}</textarea>
    </div>

    <div class="spacer">
        <button>Save Expense</button>
    </div>

</form>