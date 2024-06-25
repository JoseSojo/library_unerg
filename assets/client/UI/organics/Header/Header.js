import React, {useState} from 'react';
import Navbar from '../../molecules/Navbar/Navbar';

const Header = () => {

    return <header
        className="grid">
        
        <div className="flex justify-between px-6 py-4 bg-[#f7fbfb]">
            <span></span>
            <Navbar />
        </div>
    </header>
}

export default Header;

