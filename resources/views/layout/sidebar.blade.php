<div class="card border-0 shadow-lg mt-3">
                    <div class="card-header  text-white">
                        Navigation
                    </div>
                    <div class="card-body sidebar">
                        <ul class="nav flex-column">
                            @if (Auth::user()->role == "admin")
                            <li class="nav-item">
                                <a href="{{ route('books.index') }}">Books</a>                               
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('review.index') }}">Reviews</a>                               
                            </li>
                            @endif
                           
                            <li class="nav-item">
                                <a href="{{ route('account.profile') }}">Profile</a>                               
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('review.myReview') }}">My Reviews</a>
                            </li>
                            <li class="nav-item">
                                <a href="change-password.html">Change Password</a>
                            </li> 
                            <li class="nav-item">
                                <a href="{{ route('account.logout') }}">Logout</a>
                            </li>                           
                        </ul>
                    </div>
                </div>
            </div>