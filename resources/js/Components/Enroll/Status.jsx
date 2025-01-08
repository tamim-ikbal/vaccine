import React from 'react';
import GuestLayout from "@/Layouts/GuestLayout.jsx";
import {Head} from "@inertiajs/react";

function Status({enroll}) {
    console.log(enroll)
    return (<>
            {enroll.payload && <><h2 className="text-xl font-semibold text-gray-800 mb-4">Enroll Information</h2>
                <div className="space-y-3">
                    <div>
                        <span className="text-sm font-medium text-gray-500">Name:</span>
                        <span className="ml-2 text-gray-700">{enroll.payload.name}</span>
                    </div>
                    <div>
                        <span className="text-sm font-medium text-gray-500">NID:</span>
                        <span className="ml-2 text-gray-700">{enroll.payload.nid}</span>
                    </div>
                    <div>
                        <span className="text-sm font-medium text-gray-500">Phone:</span>
                        <span className="ml-2 text-gray-700">{enroll.payload.phone}</span>
                    </div>
                    <div>
                        <span className="text-sm font-medium text-gray-500">Email:</span>
                        <span className="ml-2 text-gray-700">{enroll.payload.email}</span>
                    </div>
                    <div>
                        <span className="text-sm font-medium text-gray-500">Vaccine:</span>
                        <span
                            className="ml-2 text-gray-700">{enroll.payload.vaccine?.name || 'Not taken!'}</span>
                    </div>
                </div>
                {enroll.payload.vaccinations?.length > 0 && <div className="mt-3">
                    <h2 className="text-xl font-semibold text-gray-800 mb-3">Vaccinations</h2>
                    <table className="w-full table-fixed">
                        <thead>
                        <tr className='text-left'>
                            <th>Dose Name</th>
                            <th>Schedule AT</th>
                            <th>Vaccinated AT</th>
                        </tr>
                        </thead>
                        <tbody>
                        {enroll.payload.vaccinations.map((vaccination) => (
                            <tr key={vaccination.dose.name}>
                                <td>{vaccination.dose.name || ''}</td>
                                <td>{vaccination.schedule_at || ''}</td>
                                <td>{vaccination.vaccinated_at || ''}</td>
                            </tr>
                        ))
                        }
                        </tbody>
                    </table>
                </div>}
            </>}
            {!enroll.payload && enroll.message}
        </>
    );
}

export default Status;
