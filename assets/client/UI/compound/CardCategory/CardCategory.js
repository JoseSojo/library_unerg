import React from 'react';
import LinkTo from '../../atoms/LinkTo/LinkTo';

const CardCategory = ({ title, url, count }) => {

    return (
        <div className="flex items-center p-3 w-72 h-28 bg-white border rounded-md shadow-lg">
            <section className="text-gray-50 font-bold flex justify-center items-center w-14 h-14 rounded-full shadow-md bg-gradient-to-r from-[#bae8e8] to-[#33749b]  hover:from-[#96d0d0] hover:to-[#216085] hover:cursor-pointer hover:scale-110 duration-400">
                {count}
            </section>

            <section className="block border-l border-gray-300 m-3">
                <div className="pl-3">
                    <h3 className="text-gray-600 font-semibold text-sm">{title}</h3>
                </div>
                <div className="flex gap-3 pt-2 pl-3">
                    <LinkTo
                        customClass=""
                    >
                        ver más <i className="bi-bi-arrow-right"></i>
                    </LinkTo>
                </div>
            </section>
        </div>
    )
}

export default CardCategory
