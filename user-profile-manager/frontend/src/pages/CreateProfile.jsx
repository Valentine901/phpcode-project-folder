import React, { useState, useRef } from 'react'
import { API } from '../constants/API';
import { useNavigate } from 'react-router-dom';

const CreateProfile = () => {
    const [firstName, setFirstName] = useState("");
    const [lastName, setLastName] = useState("");
    const [bio, setBio] = useState("");
    const [phone, setPhone] = useState("");
    const [location, setLocation] = useState("");
    const [profileImage, setProfileImage] = useState("");
    const [imagePreview, setImagePreview] = useState(null)
    const fileInputRef = useRef(null)
    const navigate = useNavigate();


    const handleImageChange = (e) => {
        const file = e.target.files[0]
        if (file) {
            setImagePreview(URL.createObjectURL(file));
            setProfileImage(file);
        }
    }

    const handleGridClick = () => {
        fileInputRef.current.click()
    }

    const handleSubmit = async (e) => {
        e.preventDefault();

        const formData = new FormData();
        formData.append("first_name", firstName);
        formData.append("last_name", lastName);
        formData.append("bio", bio);
        formData.append("phone", phone);
        formData.append("location", location);
        formData.append("profile_image", profileImage);


        try {
            await API.post("/profile/create-profile.php", formData, {
                headers: {
                    "Content-Type":"multipart/form-data"
                }
            });
            setFirstName("");
            setLastName("");
            setBio("");
            setPhone("");
            setLocation("");
            setProfileImage(null);
            console.log("profile upload success")
            navigate("/")
            
        } catch (error) {
            console.log(error.response.data.message);
        }
    }

    return (
        <div className='bg-gray-100/80 w-full min-h-screen flex'>
            <div className='max-w-xl w-full p-3 rounded-lg bg-gray-200/80 flex flex-col gap-4 mx-auto h-full my-8'>
                <h2 className='text-center text-2xl font-semibold tracking-wider'>Setup Your Profile</h2>
                <form onSubmit={handleSubmit} className='flex flex-col gap-2 mx-4'>
                    <div
                        onClick={handleGridClick}
                        className='flex flex-col items-center gap-2 cursor-pointer group'
                    >
                        <input
                            required
                            type="file"
                            ref={fileInputRef}
                            accept="image/*"
                            onChange={handleImageChange}
                            className='hidden'
                        />
                        <div className='w-64 h-64 rounded-full overflow-hidden border-2 border-gray-400 bg-gray-300 flex items-center justify-center relative group-hover:border-gray-600 transition-colors duration-200'>
                            {imagePreview ? (
                                <img src={imagePreview} alt="Profile Preview" className='w-full h-full object-cover' />
                            ) : (
                                <svg className="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            )}
                        </div>
                        <span className='text-gray-600 font-semibold text-md group-hover:text-gray-900 transition-colors duration-200'>
                            {imagePreview ? 'Click on the image grid to change the image' : 'Click to upload an image'}
                        </span>
                    </div>
                    <div className='flex flex-col gap-1 pt-4'>
                        <label htmlFor="firstName" className='font-semibold text-gray-600/80'>First Name</label>
                        <input
                            required value={firstName} onChange={(e) => setFirstName(e.target.value)} type="text" id="firstName" className='p-3 border border-gray-600/20 rounded-lg ring-offset-0 bg-gray-100 text-lg text-gray-700 font-semibold' />
                    </div>
                    <div className='flex flex-col gap-1'>
                        <label htmlFor="lastName" className='font-semibold text-gray-600/80'>Last Name</label>
                        <input
                            required value={lastName} onChange={(e) => setLastName(e.target.value)} type="text" id="lastName" className='p-3 border border-gray-600/20 rounded-lg ring-offset-0 bg-gray-100 text-lg text-gray-700 font-semibold' />
                    </div>
                    <div className='flex flex-col gap-1'>
                        <label htmlFor="phone" className='font-semibold text-gray-600/80'>Phone</label>
                        <input
                            required value={phone} onChange={(e) => setPhone(e.target.value)} type="text" id="phone" className='p-3 border border-gray-600/20 rounded-lg ring-offset-0 bg-gray-100 text-lg text-gray-700 font-semibold' />
                    </div>
                    <div className='flex flex-col gap-1'>
                        <label htmlFor="location" className='font-semibold text-gray-600/80'>Location</label>
                        <input
                            required value={location} onChange={(e) => setLocation(e.target.value)} type="text" id="location" className='p-3 border border-gray-600/20 rounded-lg ring-offset-0 bg-gray-100 text-lg text-gray-700 font-semibold' />
                    </div>
                    <div className='flex flex-col gap-1'>
                        <label htmlFor="bio" className='font-semibold text-gray-600/80'>Bio</label>
                        <textarea value={bio} onChange={(e) => setBio(e.target.value)} name="bio" id="bio" className='p-3 border border-gray-600/20 rounded-lg ring-offset-0 bg-gray-100 text-lg text-gray-700 font-semibold'>
                        </textarea>
                    </div>
                    <div className='flex justify-center'>
                        <button type="submit" className='bg-gray-800 hover:bg-gray-900 transition-all duration-300 rounded-xl py-3 px-10 text-white font-semibold text-lg'>Save</button>
                    </div>
                </form>
            </div>
        </div>
    )
}

export default CreateProfile;
