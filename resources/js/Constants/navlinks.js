////////////////////////////////////////////////////////
////////////////////////////////////////////////////////

import { TbLayoutDashboard } from "react-icons/tb";
import { TbBulb } from "react-icons/tb";
import { TbReportAnalytics } from "react-icons/tb";


export const analyticsLinks = [
    {
        name: 'dashboard',
        Icon: TbLayoutDashboard
    },
    {
        name: 'insight',
        Icon: TbBulb
    },
    {
        name: 'record',
        Icon: TbReportAnalytics
    }
];

////////////////////////////////////////////////////////
////////////////////////////////////////////////////////

import { TbArrowBarUp } from "react-icons/tb";
import { TbArrowBarToDown } from "react-icons/tb";
import { TbBuildingWarehouse } from "react-icons/tb";
import { TbPackage } from "react-icons/tb";
import { TbRecycle } from "react-icons/tb";
import { TbBuildingCog } from "react-icons/tb";

export const inventoryLinks = [
    {
        name: ['receipt', 'receipt-history'],
        Icon: TbArrowBarUp
    },
    {
        name: 'dispatch',
        Icon: TbArrowBarToDown
    },
    {
        name: 'warehouse',
        Icon: TbBuildingWarehouse
    },
    {
        name: ['product', 'product-view'],
        Icon: TbPackage
    },
    {
        name: 'return',
        Icon: TbRecycle
    },
    {
        name: 'category',
        Icon: TbCategory
    },
];

////////////////////////////////////////////////////////
////////////////////////////////////////////////////////

import { TbPinned } from "react-icons/tb";
import { TbCheckbox } from "react-icons/tb";
import { TbReportSearch } from "react-icons/tb";

export const auditLinks = [
    {
        name: 'tasks',
        Icon: TbCheckbox
    },
    {
        name: ['reports', 'reports-view', 'reports-history'],
        Icon: TbReportSearch
    },
    {
        name: ['assignments', 'assignments-view', 'assignments-history'],
        Icon: TbPinned
    },
];

export const auditLinks2 = [
    {
        name: 'tasks',
        Icon: TbCheckbox
    },
    {
        name: ['reports', 'reports-view', 'reports-history'],
        Icon: TbReportSearch
    },
];

////////////////////////////////////////////////////////
////////////////////////////////////////////////////////

import { TbHomeCog } from "react-icons/tb";
import { TbBus } from "react-icons/tb";

export const infrastructureLinks = [
    {
        name: ['depot', 'depot-history'],
        Icon: TbHomeCog
    },
    {
        name: ['terminal', 'terminal-history'],
        Icon: TbBus
    },
];

////////////////////////////////////////////////////////
////////////////////////////////////////////////////////

import { TbUserCog } from "react-icons/tb";
import { TbCategory } from "react-icons/tb";
import { TbPuzzle } from "react-icons/tb";
import { TbLogs } from "react-icons/tb";

export const managementLinks = [
    {
        name: 'user',
        Icon: TbUserCog
    },
    {
        name: ['infrastructure', 'infrastructure-view'],
        Icon: TbBuildingCog
    },
    /* {
        name: 'module',
        Icon: TbPuzzle
    }, */
    {
        name: 'logs',
        Icon: TbLogs
    },
];

export const managementLinks2 = [
    {
        name: 'user',
        Icon: TbUserCog
    },
    {
        name: ['infrastructure', 'infrastructure-view'],
        Icon: TbBuildingCog
    },
];

////////////////////////////////////////////////////////
////////////////////////////////////////////////////////

export const superAdminPages = [
    'dashboard', 'insight', 'record', 'receipt', 'dispatch', 'warehouse', 'product', 'category',
    'depot', 'terminal',
    'tasks', 'reports', /* 'assignments', */
    'user', 'infrastructure', 'logs', /* 'module' */,
]

export const adminPages = [
    'dashboard', 'insight', 'record', 'receipt', 'dispatch', 'warehouse', 'product', 'category',
    'depot', 'terminal',
    'tasks', 'reports', /* 'assignments', */
    'user', 'infrastructure',
]

export const inventoryPages = [
    'dashboard', 'insight', 'record', 'receipt', 'dispatch', 'warehouse', 'product', 'return', 'category',
]

export const infrastructurePages = [
    'depot', 'terminal',
]

export const auditPages = [
    'tasks', 'reports', 'assignments',
]