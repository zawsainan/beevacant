@php
$img = null;
$profile = null;
if(Auth::user()->role == "recruiter"){
$img = Auth::user()->company->logo;
$profile = "recruiter";
}else{
$img = Auth::user()->work_profile->profile_picture;
$profile = "job-seeker";
}

@endphp
<div class="relative py-3" id="dropDownMenu">
    <img src="{{asset('storage/'.$img)}}" class="w-20 h-20 rounded-full cursor-pointer object-cover" alt="Profile picture">
    <div id="profileDropDown" class="absolute hidden right-0 mt-2 w-48 bg-white text-black rounded-md shadow-lg z-50">
        <a
            href="/profile/{{$profile}}"
            class="block px-4 py-2 hover:bg-gray-100">
            My Profile
        </a>
        <form action="/logout" method="POST">
            @csrf
            @method("DELETE")
            <button
                class="w-full text-left px-4 py-2 hover:bg-gray-100">
                Logout
            </button>
        </form>
    </div>
</div>
<script>
    const dropDownMenu = document.getElementById("dropDownMenu");
    const profileDropDown = document.getElementById("profileDropDown");
    dropDownMenu.addEventListener("click", function() {
        profileDropDown.classList.toggle("hidden");
    });
    document.addEventListener("mousedown", function(e) {
        if (!profileDropDown.contains(e.target)) {
            profileDropDown.classList.add("hidden");
        }
    })
</script>