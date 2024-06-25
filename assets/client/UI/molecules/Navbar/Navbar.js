import React from 'react';
import Search from '../../compound/Search/Search';

const Navbar = ({ customClass=`` }) => {

    return <nav
        className={`${customClass} text-md`}
    >
        <Search />
    </nav>
}

export default Navbar;

