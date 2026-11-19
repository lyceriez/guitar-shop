<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Guitar Shop Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4 mb-5">

    {{-- DASHBOARD HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">🎸 Guitar Shop Management System</h2>
            <small class="text-muted">
                Welcome, {{ auth()->user()->name }}!
            </small>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="btn btn-danger">
                Logout
            </button>
        </form>

    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- VALIDATION ERRORS --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Please correct the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- DASHBOARD TABS --}}
    <ul class="nav nav-tabs mb-4" id="shopTabs" role="tablist">

        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab"
                data-bs-target="#brands" type="button">
                Brands
            </button>
        </li>

        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab"
                data-bs-target="#guitars" type="button">
                Guitars
            </button>
        </li>

        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab"
                data-bs-target="#specifications" type="button">
                Specifications
            </button>
        </li>

        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab"
                data-bs-target="#customers" type="button">
                Customers
            </button>
        </li>

        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab"
                data-bs-target="#purchases" type="button">
                Purchases
            </button>
        </li>

    </ul>

    <div class="tab-content">

        {{-- ===================================== --}}
        {{-- BRAND TAB --}}
        {{-- ===================================== --}}

        <div class="tab-pane fade show active" id="brands">

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    Add Guitar Brand
                </div>

                <div class="card-body">

                    <form action="{{ route('brand.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Brand Name</label>
                            <input type="text" name="name"
                                class="form-control"
                                value="{{ old('name') }}"
                                placeholder="Example: Fender" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <input type="text" name="country"
                                class="form-control"
                                value="{{ old('country') }}"
                                placeholder="Example: USA">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Save Brand
                        </button>
                    </form>

                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-dark text-white">
                    Guitar Brands List
                    <span class="text-success fw-bold ms-2">(One-to-Many Relationship)</span>
                </div>

                <div class="card-body table-responsive">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Brand Name</th>
                                <th>Country</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($brands as $brand)
                                <tr>
                                    <td>{{ $brand->id }}</td>
                                    <td>{{ $brand->name }}</td>
                                    <td>{{ $brand->country ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">
                                        No brands found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

        </div>


        {{-- ===================================== --}}
        {{-- GUITAR TAB --}}
        {{-- ===================================== --}}

        <div class="tab-pane fade" id="guitars">

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    Add Guitar
                </div>

                <div class="card-body">

                    <form action="{{ route('guitar.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Select Brand</label>

                            <select name="brand_id" class="form-select" required>
                                <option value="">Choose a brand</option>

                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Guitar Name</label>
                            <input type="text" name="name"
                                class="form-control"
                                value="{{ old('name') }}"
                                placeholder="Example: Stratocaster" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Model</label>
                            <input type="text" name="model"
                                class="form-control"
                                value="{{ old('model') }}"
                                placeholder="Example: Player Series">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" name="price"
                                class="form-control"
                                value="{{ old('price') }}"
                                min="0" step="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity"
                                class="form-control"
                                value="{{ old('quantity', 0) }}"
                                min="0" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description"
                                class="form-control"
                                rows="3">{{ old('description') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Save Guitar
                        </button>
                    </form>

                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-dark text-white">
                    Guitar List
                    <span class="text-success fw-bold ms-2">(Belongs-To Relationship: Brand)</span>
                </div>

                <div class="card-body table-responsive">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Guitar</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Price</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($guitars as $guitar)
                                <tr>
                                    <td>{{ $guitar->id }}</td>
                                    <td>{{ $guitar->name }}</td>
                                    <td>{{ $guitar->brand->name ?? 'N/A' }}</td>
                                    <td>{{ $guitar->model ?? 'N/A' }}</td>
                                    <td>{{ number_format($guitar->price, 2) }}</td>
                                    <td>{{ $guitar->quantity }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        No guitars found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

        </div>


        {{-- ===================================== --}}
        {{-- SPECIFICATION TAB --}}
        {{-- ===================================== --}}

        <div class="tab-pane fade" id="specifications">

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    Add Guitar Specification
                </div>

                <div class="card-body">

                    <form action="{{ route('specification.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Select Guitar</label>

                            <select name="guitar_id" class="form-select" required>
                                <option value="">Choose a guitar</option>

                                @foreach($guitars as $guitar)
                                    @if(!$guitar->specification)
                                        <option value="{{ $guitar->id }}"
                                            {{ old('guitar_id') == $guitar->id ? 'selected' : '' }}>
                                            {{ $guitar->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Body Material</label>
                            <input type="text" name="body_material"
                                class="form-control"
                                value="{{ old('body_material') }}"
                                placeholder="Example: Mahogany" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pickup Type</label>
                            <input type="text" name="pickup_type"
                                class="form-control"
                                value="{{ old('pickup_type') }}"
                                placeholder="Example: Humbucker" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Number of Strings</label>
                            <input type="number" name="number_of_strings"
                                class="form-control"
                                value="{{ old('number_of_strings', 6) }}"
                                min="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Color</label>
                            <input type="text" name="color"
                                class="form-control"
                                value="{{ old('color') }}"
                                placeholder="Example: Sunburst" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Save Specification
                        </button>
                    </form>

                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-dark text-white">
                    Guitar Specifications List
                    <span class="text-success fw-bold ms-2">(One-to-One Relationship)</span>
                </div>

                <div class="card-body table-responsive">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Guitar</th>
                                <th>Body Material</th>
                                <th>Pickup Type</th>
                                <th>Strings</th>
                                <th>Color</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($specifications as $spec)
                                <tr>
                                    <td>{{ $spec->id }}</td>
                                    <td>{{ $spec->guitar->name ?? 'N/A' }}</td>
                                    <td>{{ $spec->body_material }}</td>
                                    <td>{{ $spec->pickup_type }}</td>
                                    <td>{{ $spec->number_of_strings }}</td>
                                    <td>{{ $spec->color }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        No specifications found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

        </div>


        {{-- ===================================== --}}
        {{-- CUSTOMER TAB --}}
        {{-- ===================================== --}}

        <div class="tab-pane fade" id="customers">

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    Add Customer
                </div>

                <div class="card-body">

                    <form action="{{ route('customer.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Customer Name</label>
                            <input type="text" name="name"
                                class="form-control"
                                value="{{ old('name') }}"
                                placeholder="Enter customer name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                class="form-control"
                                value="{{ old('email') }}"
                                placeholder="customer@example.com" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone"
                                class="form-control"
                                value="{{ old('phone') }}"
                                placeholder="Enter phone number">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address"
                                class="form-control"
                                rows="3">{{ old('address') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Save Customer
                        </button>
                    </form>

                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-dark text-white">
                    Customer List
                    <span class="text-success fw-bold ms-2">(Many-to-Many Relationship with Guitars)</span>
                </div>

                <div class="card-body table-responsive">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($customers as $customer)
                                <tr>
                                    <td>{{ $customer->id }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone ?? 'N/A' }}</td>
                                    <td>{{ $customer->address ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        No customers found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

        </div>


        {{-- ===================================== --}}
        {{-- PURCHASE TAB --}}
        {{-- ===================================== --}}

        <div class="tab-pane fade" id="purchases">

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    Record Guitar Purchase
                </div>

                <div class="card-body">

                    <form action="{{ route('purchase.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Select Customer</label>

                            <select name="customer_id" class="form-select" required>
                                <option value="">Choose a customer</option>

                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Guitar(s)</label>

                            @forelse($guitars as $guitar)
                                <div class="form-check">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        name="guitars[]"
                                        value="{{ $guitar->id }}"
                                        id="guitar{{ $guitar->id }}"
                                        {{ in_array($guitar->id, old('guitars', [])) ? 'checked' : '' }}>

                                    <label class="form-check-label"
                                        for="guitar{{ $guitar->id }}">
                                        {{ $guitar->name }}
                                        - {{ $guitar->brand->name ?? 'No Brand' }}
                                        ({{ number_format($guitar->price, 2) }})
                                    </label>
                                </div>
                            @empty
                                <p class="text-muted">No guitars available. Add a guitar first.</p>
                            @endforelse
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Purchase Date</label>
                            <input type="date" name="purchase_date"
                                class="form-control"
                                value="{{ old('purchase_date', date('Y-m-d')) }}"
                                required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Save Purchase
                        </button>
                    </form>

                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-dark text-white">
                    Customer Purchase Records
                    <span class="text-success fw-bold ms-2">(Many-to-Many Relationship)</span>
                </div>

                <div class="card-body">

                    @forelse($customers as $customer)

                        <div class="border rounded p-3 mb-3">

                            <h5>{{ $customer->name }}</h5>

                            <p class="text-muted mb-2">
                                {{ $customer->email }}
                            </p>

                            <strong>Purchased Guitars:</strong>

                            @forelse($customer->guitars as $guitar)
                                <div class="mt-2">
                                    <span class="badge bg-primary">
                                        {{ $guitar->name }}
                                    </span>

                                    <small class="text-muted">
                                        Purchase Date:
                                        {{ $guitar->pivot->purchase_date }}
                                    </small>
                                </div>
                            @empty
                                <p class="text-muted mt-2 mb-0">
                                    No purchases recorded.
                                </p>
                            @endforelse

                        </div>

                    @empty
                        <p class="text-muted">No customers found.</p>
                    @endforelse

                </div>
            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>