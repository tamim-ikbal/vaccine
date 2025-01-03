import React from 'react';
import GuestLayout from "@/Layouts/GuestLayout.jsx";
import {Head} from "@inertiajs/react";

function Status({enroll}) {
    return (<>
            {enroll.payload && <><h2 className="text-xl font-semibold text-gray-800 mb-4">User Information</h2>
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
                        <span className="text-sm font-medium text-gray-500">Status:</span>
                        <span
                            className="ml-2 inline-block px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded-md">{enroll.payload.status}</span>
                    </div>
                    <div>
                        <span className="text-sm font-medium text-gray-500">Scheduled At:</span>
                        {enroll.payload.schedule_at &&
                            <span
                                className="ml-2 inline-block px-2 py-1 text-xs font-semibold text-white bg-blue-500 rounded-md">
       {enroll.payload.schedule_at}
      </span>}
                    </div>
                </div>
            </>}
            {!enroll.payload && enroll.message}
        </>
    );
}

export default Status;
