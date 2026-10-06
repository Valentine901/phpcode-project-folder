import { useAuth } from "../context/AuthContext"
import Loader from "../components/Loader";
import { User, Phone, MapPin, Fingerprint, Pencil } from "lucide-react";
import { useNavigate } from "react-router-dom";

const BASE_IMAGE_URL = "http://localhost/phpcodes/user-profile-manager/backend/uploads/profiles/"

const Home = () => {

  const { Logout, profile, profileLoading, error } = useAuth();
  const navigate = useNavigate();

  if (profileLoading) return <Loader />

  if (!error) {
    return (
      <div className='bg-gray-100/80 w-full min-h-screen flex'>
        <div className="flex gap-5 p-6 w-full">
          <div className="bg-gray-200/60 shadow-sm w-full max-w-lg rounded-xl p-6 text-black text-2xl flex flex-col mx-auto">
            {/* profile image container */}
            <div className="w-64 h-64 items-center flex mx-auto">
              <img className="w-full h-full object-cover rounded-full" src={`${BASE_IMAGE_URL}/${profile.profile_image}`} alt="" />
            </div>
            {/* profile details */}
            <div className="flex flex-col gap-4 my-4">
              <div className="flex items-center gap-4 bg-gray-200/80 p-3 rounded-full shadow-xs">
                <div className="text-base text-gray-600/50 font-semibold">
                  <User />
                </div>
                <p className="text-lg font-semibold text-gray-600">{profile.first_name} {profile.last_name}</p>
              </div>

              <div className="flex items-center gap-4 bg-gray-200/80 p-3 rounded-full shadow-xs">
                <div className="text-base text-gray-600/50 font-semibold">
                  <MapPin />
                </div>
                <p className="text-lg font-semibold text-gray-600">{profile.location}</p>
              </div>


              <div className="flex items-center gap-4 bg-gray-200/80 p-3 rounded-full shadow-xs">
                <div className="text-base text-gray-600/50 font-semibold">
                  <Phone />
                </div>
                <p className="text-lg font-semibold text-gray-600">{profile.phone}</p>
              </div>

              <div className="flex items-center gap-4 bg-gray-200/80 px-3  py-6 rounded-sm shadow-xs">
                <div className="text-base text-gray-600/50 font-semibold">
                  <Fingerprint />
                </div>
                <p className="text-lg font-semibold text-gray-600">{profile.bio}</p>
              </div>

              <div className="flex mx-auto pt-4">
                <button onClick={Logout} className="text-lg font-semibold rounded-full bg-gray-800 text-white py-3 px-8 hover:bg-gray-900 transition-all duration-300">Logout</button>
              </div>

            </div>
          </div>

        </div>
      </div>
    )
  } else {
    return (
      <div className="flex items-center justify-center p-4">

        <div className="max-w-2xl w-full bg-gray-200/60 rounded-md shadow-md h-64 flex flex-col gap-4 mx-auto items-center pt-6">
          <button onClick={Logout} className="py-4 max-w-xl w-full bg-gray-800 hover:bg-gray-900 transition-all duration-300 text-gray-100 font-semibold text-lg rounded-xl">Logout</button>
          <button onClick={() => navigate("/create-profile")}  className="py-4 max-w-xl w-full bg-gray-800 hover:bg-gray-900 transition-all duration-300 text-gray-100 font-semibold text-lg rounded-xl">Create Profile</button>
        </div>

      </div>
    )
  }
}

export default Home