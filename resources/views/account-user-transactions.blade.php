@extends('layouts.home')

@section('content')
    <!--=================================
    breadcrumb -->
    <div class="bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"> <i class="fas fa-home"></i> </a></li>
                        @foreach (Request::segments() as $segment)
                            <li class="breadcrumb-item">
                                <i class="fas fa-chevron-right"></i>
                                @if ($loop->last)
                                    <span>{{ ucfirst($segment) }}</span>
                                @else
                                    <a
                                        href="{{ url(implode('/', array_slice(Request::segments(), 0, $loop->index + 1))) }}">
                                        {{ ucfirst($segment) }}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--=================================
      breadcrumb -->

    <!--=================================
      My profile -->
    <section style="padding-top: 10px; padding-bottom: 50px;">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-5">
                    <div class="profile-sidebar">
                        <div class="d-sm-flex align-items-center position-relative">


                            <div class="ms-auto my-4 mt-sm-0">
                                <a class="btn btn-primary btn-md" href="{{ route('add.listing') }}"> <i
                                        class="fa fa-plus-circle"></i>Add Property </a>
                            </div>

                        </div>
                        <div class="profile-nav">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard') }}"><i class="far fa-user"></i> Edit
                                        Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('properties.my') }}"><i class="far fa-bell"></i>My
                                        properties</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('properties.saved') }}"><i class="fas fa-home"></i> Saved
                                        Properties</a>
                                </li>
                                
                                <li class="nav-item">
                                  <a class="nav-link active" href="{{ route('user.transactions') }}"><i class="far fa-edit"></i>
                                      Transactions</a>
                              </li>
                                <li class="nav-item">
                                    <!-- Hidden Logout Form -->
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                    <!-- Logout Link -->
                                    <a class="nav-link" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class='fas fa-sign-out-alt'></i> Log Out
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                <div class="col-lg-9">
                  <h2 class="text-center mb-4">My Transactions</h2>

                  <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                      <thead class="bg-primary text-white">
                        <tr>
                          <th>Date</th>
                          <th>Service</th>
                          <th>Source</th>
                          <th>Amount</th>
                          <th>Status</th>
                          <th>Note</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($transactions as $transaction)
                          <tr>
                            <td>{{ $transaction->transaction_date->format('d-m-Y') }}</td>
                            <td>{{ $transaction->service }}</td>
                            <td>{{ $transaction->source }}</td>
                            <td>AED {{ number_format($transaction->amount, 2) }}</td>
                            <td>
                              <span class="badge 
                                @if($transaction->status == 'Completed') bg-success 
                                @elseif($transaction->status == 'Pending') bg-warning 
                                @else bg-danger 
                                @endif">
                                {{ $transaction->status }}
                              </span>
                            </td>
                            <td>{{ $transaction->note }}</td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan="5" class="text-center">No transactions found.</td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                
                {{ $transactions->links() }} <!-- Pagination links -->
                
              </div>
            </div>

            </div>
        </div>
    </section>
    <!--=================================
      My profile -->
@endsection
