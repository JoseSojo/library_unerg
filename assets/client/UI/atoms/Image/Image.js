import React from 'react';

const Image = ({ path, customClass, alternative }) => {

    return <img src={path} alt={alternative} className={`${customClass}`} />
}

export default Image;

