import React from 'react'
import Link from 'next/link'
import {FaGithub, FaFacebook, FaYoutube, FaInstagram} from 'react-icons/fa'

const socials = [
    {icon: <FaGithub />, path: ''},
    {icon: <FaFacebook />, path: ''},
    {icon: <FaYoutube />, path: ''},
    {icon: <FaInstagram />, path: ''},
]

const Social = ({containerStyles, iconStyles}) => {
  return (
    <div className={containerStyles}>
      {socials.map((item, index)=> {
        return (
            <Link key={index} href={item.path} className={iconStyles}>
                {item.icon}
            </Link>
        )
      })}
    </div>
  )
}

export default Social

