<div class="order-filters">
    <div class="order-filter-field">
        <label for="filter_customer_id">Customer</label>
        <select id="filter_customer_id" class="form-control select2">
            <option value="">All Customers</option>
            @foreach($filterCustomers as $customer)
                <option value="{{ $customer->id }}" {{ (string) $selectedFilters['customer_id'] === (string) $customer->id ? 'selected' : '' }}>
                    {{ $customer->customer_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="order-filter-field">
        <label for="filter_item_name">Item</label>
        <select id="filter_item_name" class="form-control select2">
            <option value="">All Items</option>
            @foreach($filterItems as $item)
                <option value="{{ $item->item_name }}" {{ $selectedFilters['item_name'] === $item->item_name ? 'selected' : '' }}>
                    {{ $item->item_name }}
                </option>
            @endforeach
            @if($selectedFilters['item_name'] && !$filterItems->contains('item_name', $selectedFilters['item_name']))
                <option value="{{ $selectedFilters['item_name'] }}" selected>{{ $selectedFilters['item_name'] }}</option>
            @endif
        </select>
    </div>
    <div class="order-filter-field">
        <label for="filter_category_1">Category 1</label>
        <select id="filter_category_1" class="form-control select2">
            <option value="">All</option>
            @foreach($filterCategory1 as $category)
                <option value="{{ $category }}" {{ $selectedFilters['category_1'] === $category ? 'selected' : '' }}>{{ $category }}</option>
            @endforeach
            @if($selectedFilters['category_1'] && !$filterCategory1->contains($selectedFilters['category_1']))
                <option value="{{ $selectedFilters['category_1'] }}" selected>{{ $selectedFilters['category_1'] }}</option>
            @endif
        </select>
    </div>
    <div class="order-filter-field">
        <label for="filter_category_2">Category 2</label>
        <select id="filter_category_2" class="form-control select2">
            <option value="">All</option>
            @foreach($filterCategory2 as $category)
                <option value="{{ $category }}" {{ $selectedFilters['category_2'] === $category ? 'selected' : '' }}>{{ $category }}</option>
            @endforeach
            @if($selectedFilters['category_2'] && !$filterCategory2->contains($selectedFilters['category_2']))
                <option value="{{ $selectedFilters['category_2'] }}" selected>{{ $selectedFilters['category_2'] }}</option>
            @endif
        </select>
    </div>
    <div class="order-filter-field">
        <label for="filter_category_3">Category 3</label>
        <select id="filter_category_3" class="form-control select2">
            <option value="">All</option>
            @foreach($filterCategory3 as $category)
                <option value="{{ $category }}" {{ $selectedFilters['category_3'] === $category ? 'selected' : '' }}>{{ $category }}</option>
            @endforeach
            @if($selectedFilters['category_3'] && !$filterCategory3->contains($selectedFilters['category_3']))
                <option value="{{ $selectedFilters['category_3'] }}" selected>{{ $selectedFilters['category_3'] }}</option>
            @endif
        </select>
    </div>
    <div class="order-filter-actions">
        <button type="button" id="apply_order_filters" class="btn btn-primary">Search</button>
        <a href="{{ $resetRoute }}" class="btn btn-default">Reset</a>
    </div>
</div>
